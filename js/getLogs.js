export async function getLogs() {
    try {
        const res = await fetch(
            'http://localhost/projets-php/vol-d-oiseau/getLogs.php'
        )
        if (!res.ok) {
            throw new Error('ERROR !')
        }
        const logs = await res.json()
        const logRows = logs.map(
            ({ ville1, ville2, distance, requested_at }) => {
                const logTableRow = document.createElement('tr')
                logTableRow.innerHTML += `
            <td>${ville1}</td>
            <td>${ville2}</td>
            <td>${distance}</td>
            <td>${requested_at}</td>`
                return logTableRow
            }
        )
        const tbody = document.querySelector('tbody')
        tbody.innerHTML = ''
        tbody.append(...logRows)
    } catch (e) {
        console.log(e)
    }
}
