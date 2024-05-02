import { reactive } from 'vue';

const state = reactive({
    service: [
        { baseUrl: 'http://127.0.0.1:8000/', token: 'token1' },
        { baseUrl: 'http://192.168.0.8:8000/', token: 'token2' },
        // Agrega más opciones según sea necesario
    ],
    selectedServiceIndex: 0, // Índice predeterminado
});

function updateServiceConfig(index, axios) {
    state.selectedServiceIndex = index;
    // Actualizar la URL base y el token en función del índice
    const { baseUrl } = state.service[index];
    const tokenKey = `access_token_${index}`;
    const token = localStorage.getItem(tokenKey) || '';
    axios.defaults.baseURL = baseUrl;
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export default updateServiceConfig;
