import { createStore } from "vuex";
import userStore from "./user-store";
import loginStore from "./login-store";
import staffStore from "./staff-store";
// ------------

export default createStore({
  state: {
    pageName: '' as string
  },
  getters: {
    pageName(state) {
      return state.pageName;
    }
  },
  mutations: {
    setPageName(state, name: string) {
      state.pageName = name;
    }
  },
  modules: {
    userStore,
    loginStore,
    staffStore
  }
});
