@extends('layouts.main')
@section('content')
    <style>
        canvas {
            position: absolute;
        }
    </style>
    <div class="text-center text-2xl font-bold my-4">Camera tư vấn thời gian thực</div>
    <div class="flex justify-center items-center mb-4">
        <div class="relative">
            <div class="body_video flex justify-center items-center">
                <video src="" id="videoElm" autoplay='true' class="rounded-lg"></video>
            </div>
            <div class="absolute bottom-2 right-2 text-white text-sm bg-red-600 bg-opacity-75 p-2 rounded">Live</div>
        </div>
    </div>
    <div class="text-center text-xl my-4">
        <span class="font-semibold">
            Đề xuất kính:
        </span>
        <span id="phan_tich">
            Đây là một số mô hình kính được đề xuất dựa trên phân tích
        </span>
    </div>
    <div class="container mx-auto p-4">
        <div class="text-3xl md:text-4xl font-bold mb-6 text-indigo-600">Hệ Thống Tư Vấn</div>

        <div class="mb-6">
            <label for="question" class="block text-xl font-medium text-gray-700">Câu Hỏi</label>
            <textarea id="question" name="question" rows="4"
                class="mt-2 p-3 w-full rounded-md border-gray-300 shadow-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-100 text-gray-700 font-semibold text-lg disabled:opacity-75"
                disabled>Mặt ... ,... tuổi ,giới tính ... phù hợp với kính ... vì ?</textarea>
        </div>

        <div class="mb-6">
            <label for="answer" class="block text-xl font-medium text-gray-700">Câu trả lời</label>
            <div class="relative rounded-md shadow-lg">
                <textarea id="answer" name="answer" rows="4"
                    class="mt-2 p-3 w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 bg-gray-100 text-gray-700"
                    disabled>
                Lời tư vấn...
              </textarea>
                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                    <div id="loading" class="hidden">
                        <img class="h-20 w-20" src="{{ asset('asset/local/loading.gif') }}" alt="Đang tải..." />
                    </div>
                </div>
            </div>

            <a href="{{ route('product_filter') }}" class="mt-3 hidden" id="link_de_xuat">
                <i class="fas fa-external-link-alt mr-2"></i>
                Sản phẩm phù hợp
            </a>
        </div>

        <button id="nut_tu_van"
            class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-lg px-6 py-3 text-center transition-transform transform hover:scale-105">
            Tư Vấn
        </button>
    </div>

    <script src="{{ asset('js/face-api.min.js') }}"></script>
    <script>
        const video = document.getElementById('videoElm');

        const loadFaceAPI = async () => {
            await faceapi.nets.faceLandmark68Net.loadFromUri('https://pokestore.info.vn/vision/public/models');
            await faceapi.nets.faceRecognitionNet.loadFromUri('https://pokestore.info.vn/vision/public/models');
            await faceapi.nets.tinyFaceDetector.loadFromUri('https://pokestore.info.vn/vision/public/models');
            await faceapi.nets.faceExpressionNet.loadFromUri('https://pokestore.info.vn/vision/public/models');
            await faceapi.nets.ageGenderNet.loadFromUri('https://pokestore.info.vn/vision/public/models');
        }

        function getCameraStream() {
            if (navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: {}
                    })
                    .then(stream => {
                        video.srcObject = stream;
                    })
                    .catch(error => {
                        console.error("Lỗi truy cập vào máy ảnh:", error);
                    });
            } else {
                console.error("Phương tiện người dùng không được hỗ trợ trong trình duyệt này.");
            }
        }

        function euclideanDistance(point1, point2) {
            const xDiff = point1.x - point2.x;
            const yDiff = point1.y - point2.y;
            return Math.sqrt(xDiff * xDiff + yDiff * yDiff);
        }

        // function determineFaceShape(jawWidth, faceHeight, noseHeight, eyeDistance, foreheadWidth, noseWidth, eyeWidth,
        //     foreheadHeight, chinLength) {
        //     // Tính tỉ lệ giữa chiều cao khuôn mặt và chiều rộng hàm
        //     const faceRatio = faceHeight / jawWidth;
        //     // Tính tỉ lệ giữa chiều cao mũi và chiều cao khuôn mặt
        //     const noseToFaceRatio = noseHeight / faceHeight;
        //     // Tính tỉ lệ giữa khoảng cách giữa hai mắt và chiều rộng hàm
        //     const eyeToJawRatio = eyeDistance / jawWidth;
        //     // Tính tỉ lệ giữa chiều rộng hàm và chiều rộng trán
        //     const jawToForeheadRatio = jawWidth / foreheadWidth;
        //     // Tính tỉ lệ giữa chiều rộng mũi và chiều rộng hàm
        //     const noseToJawRatio = noseWidth / jawWidth;
        //     // Tính tỉ lệ giữa chiều rộng của mắt và chiều rộng hàm
        //     const eyeToJawWidthRatio = eyeWidth / jawWidth;
        //     // Tính tỉ lệ giữa chiều cao trán và chiều cao khuôn mặt
        //     const foreheadToFaceRatio = foreheadHeight / faceHeight;
        //     // Tính tỉ lệ giữa độ dài của cằm và chiều cao khuôn mặt
        //     const chinToFaceRatio = chinLength / faceHeight;

        //     console.log(faceRatio + "   " + noseToFaceRatio + "   " + jawToForeheadRatio)

        //     // Dựa vào các tỉ lệ đã tính, xác định hình dạng khuôn mặt
        //     if (faceRatio > 0.78) {
        //         if (jawToForeheadRatio < 1.92) {
        //             return 'Trái xoan';
        //         } else {
        //             return 'Dài';
        //         }
        //     } else if (faceRatio > 0.73) {
        //         if (noseToFaceRatio > 0.29) {
        //             return 'Tròn';
        //         } else if (jawToForeheadRatio > 1.87) {
        //             return 'Chữ nhật';
        //         } else {
        //             return 'bầu dục';
        //         }
        //     } else {
        //         if (eyeToJawRatio > 0.39) {
        //             return 'Tam giác';
        //         } else if (noseToJawRatio > 0.17) {
        //             return 'Trái tim';
        //         } else if (eyeToJawWidthRatio > 0.12 && foreheadToFaceRatio < 0.25) {
        //             return 'Vuông cân đối';
        //         } else if (foreheadWidth < jawWidth && chinToFaceRatio > 0.10) {
        //             return 'Vuông cổ điển';
        //         } else if (foreheadWidth > jawWidth) {
        //             return 'Vuông mềm mại';
        //         } else {
        //             return 'Vuông';
        //         }
        //     }
        // }

        function determineFaceShape(jawWidth, faceHeight, noseHeight, eyeDistance, foreheadWidth, noseWidth, eyeWidth,
            foreheadHeight, chinLength) {
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

            console.log(faceRatio + "   "+ noseToJawRatio)

            // Dựa vào các tỉ lệ đã tính, xác định hình dạng khuôn mặt
            if (faceRatio > 0.785) {
                if (jawToForeheadRatio < 1.92) {
                    return 'Chữ nhật';
                } else {
                    return 'Dài';
                }
            } else if (faceRatio > 0.76) {
                if (jawToForeheadRatio > 1.87) {
                    return 'Trái xoan';
                } else {
                    return 'bầu dục';
                }
            } else {
                if (noseToJawRatio > 0.17) {
                    return 'Tròn';
                } 
                else if (noseToJawRatio > 0.16) {
                    return 'Trái tim';
                }
                else if (eyeToJawWidthRatio > 0.14 && foreheadToFaceRatio < 0.25) {
                    return 'Vuông cân đối';
                } else if (foreheadWidth < jawWidth && chinToFaceRatio > 0.24) {
                    return 'Vuông cổ điển';
                } else if (foreheadWidth > jawWidth) {
                    return 'Vuông mềm mại';
                } else {
                    return 'Vuông';
                }
            }
        }

        // function determineFaceShape(jawWidth, faceHeight, noseHeight, eyeDistance, foreheadWidth, noseWidth, eyeWidth,
        //     foreheadHeight, chinLength) {

        //     // Tính tỉ lệ giữa chiều cao và chiều rộng của khuôn mặt
        //     const faceRatio = faceHeight / jawWidth;
        //     // Tính tỉ lệ giữa chiều rộng của hàm và trán
        //     const jawForeheadRatio = jawWidth / foreheadWidth;
        //     // Tính tỉ lệ giữa chiều cao của trán so với khuôn mặt
        //     const foreheadFaceRatio = foreheadHeight / faceHeight;
        //     // Tính tỉ lệ giữa chiều dài của cằm so với chiều cao khuôn mặt
        //     const chinFaceRatio = chinLength / faceHeight;

        //     console.log(faceRatio + "   " + jawForeheadRatio + "   " + foreheadFaceRatio + "   " + chinFaceRatio)

        //     // Xác định hình dạng khuôn mặt dựa vào các tỉ lệ
        //     if (jawWidth > foreheadWidth && chinLength >= faceHeight / 5 && faceRatio >= 0.7 && faceRatio < 1 &&
        //         jawForeheadRatio >= 1.8) {
        //         return 'Vuông cổ điển';
        //     }
        //     // Tiêu chí cho mặt dài
        //     else if (faceRatio >= 0.8 && faceRatio < 1 && jawForeheadRatio < 1.8 && foreheadFaceRatio > 0.25 &&
        //         chinFaceRatio >= 0.35) {
        //         return 'Dài';
        //     } else if (faceRatio >= 1.2 && faceRatio < 1.3 && jawForeheadRatio >= 0.8 && jawForeheadRatio < 1 &&
        //         chinFaceRatio < 0.1) {
        //         return 'Trái xoan';
        //     } else if (faceRatio <= 1 && jawForeheadRatio <= 0.8 && chinFaceRatio > 0.1) {
        //         return 'Tròn';
        //     } else if (faceRatio >= 1.1 && faceRatio < 1.2 && jawForeheadRatio > 0.9) {
        //         return 'Chữ nhật';
        //     } else if (faceRatio >= 1.2 && faceRatio < 1.3 && jawForeheadRatio >= 1 && chinFaceRatio >= 0.1) {
        //         return 'Bầu dục';
        //     } else if (jawForeheadRatio > 1 && chinFaceRatio < 0.1) {
        //         return 'Tam giác';
        //     } else if (jawForeheadRatio < 1 && foreheadWidth > jawWidth && chinLength < (faceHeight / 5)) {
        //         return 'Trái tim';
        //     } else if (jawWidth === foreheadWidth && chinLength > (faceHeight / 5)) {
        //         return 'Vuông cân đối';
        //     } else if (jawWidth < foreheadWidth && chinLength > (faceHeight / 5)) {
        //         return 'Vuông mềm mại';
        //     } else {
        //         return 'Vuông';
        //     }

        // }

        function adjustAge(age, gender) {
            let adjustedAge = age;
            if (gender === 'male') adjustedAge = age + 4;
            if (gender === 'female') adjustedAge = age + 3;

            return adjustedAge;
        }
        async function getCompletion(prompt) {
            const API_KEY = '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'
            const res = await fetch('https://api.openai.com/v1/chat/completions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + API_KEY,
                },
                body: JSON.stringify({
                    model: 'gpt-3.5-turbo',
                    messages: [{
                        "role": "user",
                        "content": prompt + "Trả lời dưới 100 chữ nhé !",
                    }]
                })
            })
            return await res.json()
        }
        


        function kinh_hop(age, gender, faceShape) {
            // Bảng đề xuất kính dựa trên hình dạng khuôn mặt
            const recommendations = {
                'Trái xoan': 'Kính mắt hình bầu dục hoặc hình chữ nhật',
                'Dài': 'Kính mắt hình vuông hoặc tròn',
                'Tròn': 'Kính mắt hình chữ nhật hoặc mắt hình chéo',
                'Chữ nhật': 'Kính mắt hình tròn hoặc bầu dục',
                'Bầu dục': 'Hầu hết các kiểu kính đều phù hợp',
                'Tam giác': 'Kính mắt tròn ít hoạ tiết',
                'Trái tim': 'Kính mắt hình bầu dục hoặc mắt hình chéo',
                'Vuông cân đối': 'Kính mắt hình bầu dục hoặc hình tròn',
                'Vuông cổ điển': 'Kính mắt hình bầu dục',
                'Vuông mềm mại': 'Kính mắt hình tròn',
                'Vuông': 'Kính mắt hình tròn hoặc bầu dục'
            };

            let recommendation = recommendations[faceShape] || 'Không tìm thấy đề xuất cho hình dạng khuôn mặt này';

            // Tinh chỉnh đề xuất dựa trên giới tính
            if (gender === 'male') {
                recommendation += ', các mẫu kính nam tính,';
            } else if (gender === 'female') {
                recommendation += ', các mẫu kính nữ tính,';
            }

            // Tinh chỉnh đề xuất dựa trên độ tuổi
            if (age < 18) {
                recommendation += ' kính có kiểu dáng năng động và trẻ trung';
            } else if (age >= 18 && age <= 35) {
                recommendation += ' kính có kiểu dáng hiện đại và thời trang';
            } else {
                recommendation += ' kính có kiểu dáng lịch sự và tinh tế';
            }

            return recommendation;
        }

        function make_link(inputString) {
            link = "https://pokestore.info.vn/vision/product/filter"
            // Tạo một biểu thức chính quy để trích xuất thông tin
            const regex = /Mặt\s(.*),(\d+)\stuổi\s,giới\s+tính\s(.*?)\sphù\shợp\s+với/;

            // Áp dụng biểu thức chính quy vào chuỗi đầu vào
            const match = inputString.match(regex);

            // Kiểm tra xem có tìm thấy kết quả hay không
            if (match && match.length >= 4) {
                // xử lý điều kiện
                dang_mat = match[1].trim()
                tuoi = parseInt(match[2].trim())
                gioi_tinh = match[3].trim()

                // Điều kiện khuông mặt 
                link = link + "?shape_face_ai=" + dang_mat + "&age_ai=" + tuoi + "&sex_ai=" + gioi_tinh
            }
            return link;
        }
        
        document.getElementById('nut_tu_van').addEventListener('click', async () => {
            let cau_hoi = document.getElementById('question').innerHTML
            if (cau_hoi == "Mặt ... ,... tuổi ,giới tính ... phù hợp với kính ... vì ?") return

            if (!document.getElementById('link_de_xuat').classList.contains('hidden')) {
                document.getElementById('link_de_xuat').classList.add('hidden')
            }
            // Hiển thị biểu tượng loading
            document.getElementById('loading').classList.remove('hidden');

            try {
                const response = await getCompletion(cau_hoi);
                document.getElementById('answer').value = cau_hoi + " \n  Câu trả lời: " + response.choices[0]
                    .message.content;
            } catch (error) {
                console.error('Đã xảy ra lỗi:', error);
                // Bạn có thể hiển thị thông báo lỗi tại đây nếu cần
            } finally {
                // Ẩn biểu tượng loading khi hoàn tất
                document.getElementById('loading').classList.add('hidden');
                // Xử lý tạo link đề xuất đúnng :
                document.getElementById('link_de_xuat').href = make_link(cau_hoi)
                document.getElementById('link_de_xuat').classList.remove('hidden')
            }
        })
        video.addEventListener('playing', () => {
            const canvas = faceapi.createCanvasFromMedia(video);
            document.querySelector('.body_video').append(canvas);
            const displaySize = {
                width: video.videoWidth,
                height: video.videoHeight
            };
            faceapi.matchDimensions(canvas, displaySize);

            setInterval(async () => {
                const detections = await faceapi.detectAllFaces(video, new faceapi
                        .TinyFaceDetectorOptions())
                    .withFaceLandmarks()
                    .withFaceExpressions()
                    .withAgeAndGender()

                canvas.getContext('2d').clearRect(0, 0, displaySize.width, displaySize.height);

                detections.forEach(detection => {
                    const resizedDetection = faceapi.resizeResults(detection, displaySize);
                    faceapi.draw.drawDetections(canvas, resizedDetection);

                    const landmarks = resizedDetection.landmarks;
                    const jawOutline = landmarks.getJawOutline();
                    const nose = landmarks.getNose();
                    const leftEye = landmarks.getLeftEye();
                    const rightEye = landmarks.getRightEye();
                    const mouth = landmarks.getMouth();
                    const leftEyebrow = landmarks.getLeftEyeBrow();
                    const rightEyebrow = landmarks.getRightEyeBrow();

                    const jawWidth = euclideanDistance(jawOutline[0], jawOutline[16]);
                    const faceHeight = euclideanDistance(jawOutline[8], landmarks.positions[
                        27]);
                    const noseHeight = euclideanDistance(nose[3], nose[0]);
                    const eyeDistance = euclideanDistance(leftEye[3], rightEye[0]);
                    const foreheadWidth = euclideanDistance(leftEyebrow[4], rightEyebrow[4]);
                    const noseWidth = euclideanDistance(nose[4], nose[8]);
                    const eyeWidth = (euclideanDistance(leftEye[0], leftEye[3]) +
                        euclideanDistance(
                            rightEye[0], rightEye[3])) / 2;
                    const foreheadHeight = euclideanDistance(landmarks.positions[27], landmarks
                        .positions[21]);
                    const chinLength = euclideanDistance(jawOutline[8], mouth[9]);

                    const faceShape = determineFaceShape(jawWidth, faceHeight, noseHeight,
                        eyeDistance,
                        foreheadWidth, noseWidth, eyeWidth, foreheadHeight, chinLength);

                    // const response = await getCompletion(resizedDetection.age, resizedDetection.gender,faceShape)
                    // CSS để định dạng văn bản
                    const textStyle = {
                        font: '16px Arial',
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        borderColor: 'black',
                        borderRadius: 5,
                        padding: 5,
                    };

                    const drawOptions = {
                        anchorPosition: 'BOTTOM_LEFT',
                        backgroundColor: textStyle.backgroundColor,
                    };
                    // Chỉnh sửa vị trí hiển thị văn bản
                    const box = resizedDetection.detection.box;
                    const textPosition = {
                        x: box.x,
                        y: box.y + box.height +
                            10, // Đảm bảo văn bản không che mặt và nằm ngay dưới khuôn mặt
                    };

                    // Hiển thị văn bản
                    let tu_van_kinh = kinh_hop(resizedDetection.age, resizedDetection.gender,
                        faceShape)
                    if (resizedDetection.gender == 'female' && resizedDetection.age>30) xl = "Bạn rất đẹp"; 
                    else xl = "";
                    new faceapi.draw.DrawTextField(
                        [
                            `Hình dạng khuôn mặt: ${faceShape}`,
                            `Độ tuổi: ${adjustAge(resizedDetection.age, resizedDetection.gender).toFixed(0)}`,
                            `Giới tính: ${resizedDetection.gender}`,
                            // `Bạn phù hợp với:`,
                            `${xl}`,
                        ],
                        textPosition,
                        drawOptions
                    ).draw(canvas);

                    //Xử lý dữ liệU
                    document.getElementById('phan_tich').innerHTML = tu_van_kinh
                    let gioi_tinh = "";
                    if (resizedDetection.gender == 'female') gioi_tinh = "nữ";
                    else gioi_tinh = "nam"
                    document.getElementById('question').innerHTML = "Mặt " + faceShape + " ," +
                        Math.ceil(resizedDetection.age) + " tuổi ,giới tính " + gioi_tinh +
                        " phù hợp với '" + tu_van_kinh + "'  vì ?"
                });
            }, 1000);
        });

        loadFaceAPI().then(getCameraStream);
    </script>
@endsection
