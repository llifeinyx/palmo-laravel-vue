export default {
    stateToken: (state) => localStorage.getItem('x_xsrf_token'),
    stateUser: (state) => state.user,
}
