const API_KEY = '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'

async function getCompletion(prompt) {
    const res =  await fetch('https://api.openai.com/v1/chat/completions',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'Authorization': 'Bearer '+API_KEY,
        },
        body: JSON.stringify({
            model: 'gpt-3.5-turbo',
            messages: [
                {
                    "role":"user",
                    "content":prompt,
                }
            ]            
        })
    })

    return await res.json()
}

const prompt = document.getElementById('prompt')
const button = document.getElementById('generate')
const output = document.getElementById('output')

button.addEventListener('click', async ()=>{
    if (!prompt.value) return

    const response = await getCompletion(prompt.value)
    output.innerHTML = response.choices[0].message.content
})