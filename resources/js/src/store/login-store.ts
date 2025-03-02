import axios, { AxiosError } from 'axios'

interface State {
    login: string,
    password: string
}

const state: State = {
    login: '',
    password: ''
}

const getters = {
    login: (state: State) => state.login,
    password: (state: State) => state.password
}

const mutations = {
    setLogin(state: State, newLogin: string) {
        state.login = newLogin
    },
    setPassword(state: State, newPassword: string) {
        state.password = newPassword
    }
}

const actions = {
    async loginUser({ commit }: { commit: any }, payload: { login: string, password: string }) {
        try {
            const response = await axios.post('http://127.0.0.1:8000/api/login', payload)

            console.log('✅ Вход выполнен:', response.data)

            // Можно добавить сохранение токена, если API его возвращает
            localStorage.setItem('token', response.data.token)

            // Сохранить логин в `state`
            commit('setLogin', payload.login)
        } catch (error: unknown) {
            const axiosError = error as AxiosError
            console.error('❌ Ошибка при входе:', axiosError)
            if (axiosError.response) console.error('Ответ сервера:', axiosError.response.data)
        }
    }
}

export default { state, getters, mutations, actions }
