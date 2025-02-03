const video = document.getElementById('videoElm');

const loadFaceAPI = async () => {
    await faceapi.nets.faceLandmark68Net.loadFromUri('http://127.0.0.1:8000/models');
    await faceapi.nets.faceRecognitionNet.loadFromUri('http://127.0.0.1:8000/models');
    await faceapi.nets.tinyFaceDetector.loadFromUri('http://127.0.0.1:8000/models');
    await faceapi.nets.faceExpressionNet.loadFromUri('http://127.0.0.1:8000/models');
    await faceapi.nets.ageGenderNet.loadFromUri('http://127.0.0.1:8000/models');
}

function getCameraStream() {
    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: {} })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(error => {
                console.error("Error accessing camera:", error);
            });
    } else {
        console.error("getUserMedia not supported in this browser.");
    }
}
function euclideanDistance(point1, point2) {
    const xDiff = point1.x - point2.x;
    const yDiff = point1.y - point2.y;
    return Math.sqrt(xDiff * xDiff + yDiff * yDiff);
}

video.addEventListener('playing', () => {
    const canvas = faceapi.createCanvasFromMedia(video);
    document.body.append(canvas);
    const displaySize = { width: video.videoWidth, height: video.videoHeight };
    faceapi.matchDimensions(canvas, displaySize);

    setInterval(async () => {
        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceExpressions()
            .withAgeAndGender()

        canvas.getContext('2d').clearRect(0, 0, displaySize.width, displaySize.height);

        if (detection) {
            const resizedDetection = faceapi.resizeResults(detection, displaySize);
            faceapi.draw.drawDetections(canvas, [resizedDetection]);

            const landmarks = resizedDetection.landmarks;
            const jawOutline = landmarks.getJawOutline();
            const nose = landmarks.getNose();
            const leftEye = landmarks.getLeftEye();
            const rightEye = landmarks.getRightEye();
            const mouth = landmarks.getMouth();
            const leftEyebrow = landmarks.getLeftEyeBrow();
            const rightEyebrow = landmarks.getRightEyeBrow();

            const jawWidth = euclideanDistance(jawOutline[0], jawOutline[16]);
            const faceHeight = euclideanDistance(jawOutline[8], landmarks.positions[27]);
            const noseHeight = euclideanDistance(nose[3], nose[0]);
            const eyeDistance = euclideanDistance(leftEye[3], rightEye[0]);
            const foreheadWidth = euclideanDistance(leftEyebrow[4], rightEyebrow[4]);
            const noseWidth = euclideanDistance(nose[4], nose[8]);
            const eyeWidth = (euclideanDistance(leftEye[0], leftEye[3]) + euclideanDistance(rightEye[0], rightEye[3])) / 2;
            const foreheadHeight = euclideanDistance(landmarks.positions[27], landmarks.positions[21]);
            const chinLength = euclideanDistance(jawOutline[8], mouth[9]);

            const faceShape = determineFaceShape(jawWidth, faceHeight, noseHeight, eyeDistance, foreheadWidth, noseWidth, eyeWidth, foreheadHeight, chinLength);

            new faceapi.draw.DrawTextField(
                [
                    `Hình dạng khuôn mặt: ${faceShape}`,
                    `Độ tuổi: ${adjustAge(resizedDetection.age, resizedDetection.gender).toFixed(0)}`,
                    `Giới tính: ${resizedDetection.gender}`
                ], 
                resizedDetection.detection.box.bottomLeft
            ).draw(canvas);
            
            function adjustAge(age, gender) {
                let adjustedAge = age;
                if (gender === 'male') adjustedAge = age+4;
                if (gender === 'female' && age > 40) {
                    adjustedAge -= 5;
                }
                return adjustedAge;
            }
            
        }
    }, 300);
});

function determineFaceShape(jawWidth, faceHeight, noseHeight, eyeDistance, foreheadWidth, noseWidth, eyeWidth, foreheadHeight, chinLength) {
    // Tính tỉ lệ giữa chiều cao khuôn mặt và chiều rộng hàm
    const faceRatio = faceHeight / jawWidth;
    // Tính tỉ lệ giữa chiều cao mũi và chiều cao khuôn mặt
    const noseToFaceRatio = noseHeight / faceHeight;
    // Tính tỉ lệ giữa khoảng cách giữa hai mắt và chiều rộng hàm
    const eyeToJawRatio = eyeDistance / jawWidth;
    // Tính tỉ lệ giữa chiều rộng hàm và chiều rộng trán
    const jawToForeheadRatio = jawWidth / foreheadWidth;
    // Tính tỉ lệ giữa chiều rộng mũi và chiều rộng hàm
    const noseToJawRatio = noseWidth / jawWidth;
    // Tính tỉ lệ giữa chiều rộng của mắt và chiều rộng hàm
    const eyeToJawWidthRatio = eyeWidth / jawWidth;
    // Tính tỉ lệ giữa chiều cao trán và chiều cao khuôn mặt
    const foreheadToFaceRatio = foreheadHeight / faceHeight;
    // Tính tỉ lệ giữa độ dài của cằm và chiều cao khuôn mặt
    const chinToFaceRatio = chinLength / faceHeight;

    // Dựa vào các tỉ lệ đã tính, xác định hình dạng khuôn mặt
    if (faceRatio > 1.1) {
        if (jawToForeheadRatio < 0.78) {
            return 'Trái xoan';
        } else {
            return 'Dài';
        }
    } else if (faceRatio > 1.01) {
        if (noseToFaceRatio > 0.09) {
            return 'Tròn';
        } else if (jawToForeheadRatio > 0.87) {
            return 'Chữ nhật';
        } else {
            return 'Oval';
        }
    } else {
        if (eyeToJawRatio > 0.39) {
            return 'Tam giác';
        } else if (noseToJawRatio > 0.17) {
            return 'Tim';
        } else if (eyeToJawWidthRatio > 0.12 && foreheadToFaceRatio < 0.25) {
            return 'Vuông cân đối';
        } else if (foreheadWidth < jawWidth && chinToFaceRatio > 0.10) {
            return 'Vuông cổ điển';
        } else if (foreheadWidth > jawWidth) {
            return 'Vuông mềm mại';
        } else {
            return 'Vuông';
        }
    }
}


loadFaceAPI().then(getCameraStream);