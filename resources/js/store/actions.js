import axios from 'axios'

const baseUrl = window.location.origin
export default {
    fetchTree ({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get(`${baseUrl}/api/tree`, {
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then((response) => {
                    commit('SET_TREE', response.data)
                    resolve(response)
                })
                .catch((error) => {
                    console.log(error.status)
                    reject(error)
                })
        })
    },
    updateNodeText ({ commit }, data) {
        return new Promise((resolve, reject) => {
            const config = {
                method: 'put',
                url: `${baseUrl}/api/node/${data.id}`,
                data: {
                    text: data.text
                }
            }
            axios(config)
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },
    addChildNode ({ commit }, data) {
        console.log(data)
        return new Promise((resolve, reject) => {
            const config = {
                method: 'post',
                url: `${baseUrl}/api/node`,
                data: {
                    parentId: data.parentId,
                }
            }
            axios(config)
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },
    updateNodePosition ({ commit }, data) {
        return new Promise((resolve, reject) => {
            const config = {
                method: 'PUT',
                url: `${baseUrl}/api/update-position`,
                data: data
            }
            console.log(config)
            axios(config)
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },
    removeNode ({ commit }, data) {
        console.log(commit)
        return new Promise((resolve, reject) => {
            const config = {
                method: 'DELETE',
                url: `${baseUrl}/api/node/${data.nodeId}`
            }
            axios(config)
                .then((response) => {
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    }
}
