export default (token, to, from, next) => {
    if (!token) {
        if (to.name === 'auth.login' || to.name === 'auth.register') {
            return next()
        } else if (to.name === 'profile'){
            return next({
                name: 'auth.login'
            })
        } else {
            return next()
        }
    }

    if (token) {
        if (to.name === 'auth.login' || to.name === 'auth.register') {
            return next({
                name: 'profile'
            })
        } else {
            return  next()
        }

    }
}
