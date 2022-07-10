import axios from "axios";
import {commit} from "lodash/seq";

export default {
    async getUser(context) {
        try {
            const data = await axios.get('/api/user')
            context.commit("SET_USER", data.data)
        }
        catch (e){
            context.commit("SET_USER", null)
        }
    },
}
