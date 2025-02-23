interface State {
    login: string,
    password: string
}

const state: State = {
    login: '',
    password: ''
}

const getters = {
    login(state: State){
        return state.login
    },
    password(state: State){
        return state.password
    }
}

const mutations = {
    setLogin(state: State, newLogin: string){
        state.login = newLogin
    },
    setPpassword(state: State, newPassword: string){
        state.password = newPassword
    }
}

export default { state, getters, mutations }