export async function autocomplete(inp) {
    /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
    let currentFocus
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener('input', async function (e) {
        let autoCompleteList,
            listElement,
            val = this.value
        /*close any already open lists of autocompleted values*/
        closeAllLists()
        if (!val) {
            return false
        }
        currentFocus = -1
        /*create a DIV element that will contain the items (values):*/
        autoCompleteList = document.createElement('DIV')
        autoCompleteList.setAttribute('id', this.id + 'autocomplete-list')
        autoCompleteList.setAttribute('class', 'autocomplete-items')
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(autoCompleteList)

        let villeId = document.querySelector(`#${inp.id}-id`)
        if (!villeId) {
            villeId = document.createElement('input')
            villeId.setAttribute('type', 'hidden')
            villeId.setAttribute('name', this.id + '-id')
            villeId.setAttribute('id', this.id + '-id')
            this.parentNode.appendChild(villeId)
        }

        /*for each item in the array...*/
        if (val.length >= 3) {
            const arr = await fetchData(val)
            arr.forEach(({ ville_id, nom, dep_num, dep_nom }) => {
                /*create a DIV element for each matching element:*/
                listElement = document.createElement('DIV')
                /*make the matching letters bold:*/
                listElement.innerHTML =
                    '<strong>' + nom.substr(0, val.length) + '</strong>'
                listElement.innerHTML +=
                    nom.substr(val.length) + `, ${dep_nom} (${dep_num})`
                /*insert a input field that will hold the current array item's value:*/
                listElement.innerHTML +=
                    "<input type='hidden' value='" +
                    `${nom}, ${dep_nom} (${dep_num})` +
                    "'>"
                /*execute a function when someone clicks on the item value (DIV element):*/
                listElement.addEventListener('click', function (e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName('input')[0].value
                    villeId.value = ville_id
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists()
                })
                autoCompleteList.appendChild(listElement)
            })
            // for (i = 0; i < arr.length; i++) {
            //     /*check if the item starts with the same letters as the text field value:*/
            //     if (
            //         arr[i].substr(0, val.length).toUpperCase() ==
            //         val.toUpperCase()
            //     ) {
            //         /*create a DIV element for each matching element:*/
            //         listElement = document.createElement('DIV')
            //         /*make the matching letters bold:*/
            //         listElement.innerHTML =
            //             '<strong>' + arr[i].substr(0, val.length) + '</strong>'
            //         listElement.innerHTML += arr[i].substr(val.length)
            //         /*insert a input field that will hold the current array item's value:*/
            //         listElement.innerHTML +=
            //             "<input type='hidden' value='" + arr[i] + "'>"
            //         /*execute a function when someone clicks on the item value (DIV element):*/
            //         listElement.addEventListener('click', function (e) {
            //             /*insert the value for the autocomplete text field:*/
            //             inp.value = this.getElementsByTagName('input')[0].value
            //             /*close the list of autocompleted values,
            //     (or any other open lists of autocompleted values:*/
            //             closeAllLists()
            //         })
            //         autoCompleteList.appendChild(listElement)
            //     }
            // }
        }
    })
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener('keydown', function (e) {
        let autoCompleteList = document.getElementById(
            this.id + 'autocomplete-list'
        )
        let autoCompleteListItems
        if (autoCompleteList) {
            autoCompleteListItems = autoCompleteList.getElementsByTagName('div')
        }
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
            currentFocus++
            /*and and make the current item more visible:*/
            addActive(autoCompleteListItems)
        } else if (e.keyCode == 38) {
            //up
            /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
            currentFocus--
            /*and and make the current item more visible:*/
            addActive(autoCompleteListItems)
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault()
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (autoCompleteListItems) {
                    autoCompleteListItems[currentFocus].click()
                }
            }
        }
    })
    function addActive(autoCompleteListItems) {
        /*a function to classify an item as "active":*/
        if (!autoCompleteListItems) return false
        /*start by removing the "active" class on all items:*/
        removeActive(autoCompleteListItems)
        if (currentFocus >= autoCompleteListItems.length) currentFocus = 0
        if (currentFocus < 0) currentFocus = autoCompleteListItems.length - 1
        /*add class "autocomplete-active":*/
        autoCompleteListItems[currentFocus].classList.add('autocomplete-active')
    }
    function removeActive(elements) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (let element of elements) {
            element.classList.remove('autocomplete-active')
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
        let items = document.getElementsByClassName('autocomplete-items')
        for (let item of items) {
            if (elmnt != item && elmnt != inp) {
                item.parentNode.removeChild(item)
            }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener('click', function (e) {
        closeAllLists(e.target)
    })

    /**
     * Sends a request to the back-end to retrieve cities' names beginning with value.
     * @param {string} value - the beginning of the cities' names to get.
     * @returns {array} An array containing 0 to 10 city objects with keys ville_id, nom, dep_num.
     */
    async function fetchData(value) {
        const formData = new FormData()
        formData.append('search', value)
        try {
            const res = await fetch(
                `http://localhost/projets-php/vol-d-oiseau/getJsonVilles.php?search=${value}`
            )
            const data = await res.json()
            return data
        } catch (e) {
            console.log(e)
        }
    }
}
