export default {
    //stateToken: (state) => localStorage.getItem('x_xsrf_token'),
    stateToken: (state) => state.token,
    stateUser: (state) => state.user,
}
