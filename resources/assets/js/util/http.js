import message from 'element-ui/lib/message.js'
export default {
    get(url, params) {
        return new Promise((resolve, reject) => {
            axios.get(url, {params:params}).then(function (res) {
                //未登录
                if(res.data.error === 4) {
                    window.sessionStorage.removeItem('userInfo');
                    location.reload();
                }
                if(res.data.error === 6) {
                    message({
                        message: res.data.msg,
                        type: 'error'
                    });
                }
                resolve(res.data);
            }).catch(resp => {
                reject(resp);
                console.log('请求失败：' + resp);
            })
        })
    },

    post(url, params) {
        return new Promise((resolve, reject) => {
            axios.post(url, params).then(function (res) {
                //未登录
                if(res.data.error === 4) {
                    window.sessionStorage.removeItem('userInfo');
                    location.reload();
                }
                if(res.data.error === 6) {
                    message({
                        message: res.data.msg,
                        type: 'error'
                    });
                }
                resolve(res.data);
            }).catch(resp => {
                reject(resp);
                console.log('请求失败：' + resp);
            })
        })
    }
}