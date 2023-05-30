import axios from "axios";
import store from "../store/store";

export default {
    GET_COMMAND: 'GET',
    POST_COMMAND: 'POST',
    PUT_COMMAND: 'PUT',
    PATCH_COMMAND: 'PATCH',
    DELETE_COMMAND: 'DELETE',
    apiBasePath: '/v1',
    callApi: async function(requestType='GET', url, params={}, headers={},  lafalafi=true) {
        url = this.apiBasePath+url;
        const methodName = requestType.toUpperCase();
        console.log(url);

        if (lafalafi)
        store.commit('processStart');
        if(methodName === 'GET' ) {
             return await  axios.get(url, params, headers)
                 .then(response => {
                     store.commit('processEnd');
                     return response;})
                 .catch(error => {
                     store.commit('processEnd');
                     return error;});
        } else if(methodName === 'POST') {
             return await  axios.post(url, params, headers)
                 .then(response => {
                     store.commit('processEnd');
                     return response;});
        } else if((methodName === 'PUT') || (methodName === 'PATCH')) {
            return await  axios.put(url, params, headers)
                .then(response => {
                    store.commit('processEnd');
                    return response;});
        } else if(methodName === 'DELETE') {
            return await  axios.delete(url, params, headers)
                .then(response => {
                    store.commit('processEnd');
                    return response;});
        }else{
            store.commit('processEnd');
            return false;
        }
    }
}


