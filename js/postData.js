import { getLogs } from './getLogs.js'

export async function postData(form, input1, input2) {
    const formData = new FormData(form)
    const name1 = input1.value.split(',')[0]
    const name2 = input2.value.split(',')[0]

    try {
        const res = await fetch(
            'http://localhost/projets-php/vol-d-oiseau/getDistance.php',
            {
                method: 'POST',
                body: formData,
            }
        )
        const { distance } = await res.json()
        const distanceDiv = document.querySelector('#distance')
        distanceDiv.innerHTML = `La distance entre ${name1} et ${name2} est de ${distance}km.`
        // getLogs()
    } catch (e) {
        console.log(e)
    }
}
