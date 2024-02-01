import { autocomplete } from './autoComplete.js'
import { postData } from './postData.js'
// import { getLogs } from './getLogs.js'

const ville1 = document.querySelector('#ville1')
const ville2 = document.querySelector('#ville2')

autocomplete(ville1)
autocomplete(ville2)

const form = document.querySelector('form')
form.onsubmit = (e) => {
    e.preventDefault()
    postData(e.target, ville1, ville2)
}
