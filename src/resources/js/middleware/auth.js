export default (token, to, from, next) => {
    if (!token) {
        if (to.name === 'auth.login' || to.name === 'auth.register') {
            return next()
        } else {
            return next()
        }
    }

    if (token) {
        if (to.name === 'auth.login' || to.name === 'auth.register') {
            return next({
                path: "/"
            })
        } else {
            return  next()
        }

    }
}
