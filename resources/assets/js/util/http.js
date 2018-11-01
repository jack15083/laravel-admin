export default {
    get(url, params, callback) {
        axios.get(url, {params:params}).then(function (res) {
            callback(res.data)
        }).catch(resp => {
            console.log('请求失败：' + resp);
        })
    },

    post(url, params, callback) {
        axios.post(url, params).then(function (res) {
            callback(res.data)
        }).catch(resp => {
            console.log('请求失败：' + resp);
        })
    }
}