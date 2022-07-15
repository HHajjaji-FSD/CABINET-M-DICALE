import {Controller} from "@hotwired/stimulus";

export default class extends Controller {

    connect() {
        this.element.querySelector('#nouveau-patient').addEventListener('turbo:frame-render', (event) => {
            event.detail.fetchResponse.responseHTML.then((data) =>{
                if(data === "Success") {
                    //Reload Patient Select
                }
            });
        });
    }

    reloadPatientSelect() {

    }

}