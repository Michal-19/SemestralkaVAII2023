class RequestSender {
    #controller

    constructor(controller) {
        this.#controller = controller
    }

    async sendRequest(action, method, responseCode, body, onErrorReturn = null) {
        try {
            let response = await fetch(
                "http://localhost?c=" + this.#controller + "&a=" + action,
                {
                    method: method,
                    body: JSON.stringify(body),
                    headers: {
                        "Content-type": "application/json",
                        "Accept" : "application/json",
                    }
                });
            //if (response.status === responseCode) return true;
            //if (response.status === 412 || response.status === 400) return await response.json();
            //return false;
            return await response.json();
        } catch(ex) {
            return onErrorReturn;
        }
    }
}

export {RequestSender}