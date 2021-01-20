import Axios from "axios"

export default{
    data(){
        return{

        }
    }, methods:{    
        async callApi(method, url, data){
            try{
               return await axios({
                    method:method,
                    url:url,
                    data:data
                });
            }catch(e){
                return e.response;
            }
            
        },
        i(desc, title='Hey'){
            this.$Notice.info({
                title:title,
                desc:desc
            })
        },
        s(desc, title='Great!'){
            this.$Notice.success({
                title:title,
                desc:desc
            })
        },
        w(desc, title='Oops'){
            this.$Notice.warning({
                title:title,
                desc:desc
            })
        },
        e(desc, title='Error'){
            this.$Notice.error({
                title:title,
                desc:desc
            })
        },
        swr(desc='Something went wrong, Please try again', title='Wrong'){
            this.$Notice.error({
                title:title,
                desc:desc
            })
        }

    }
}