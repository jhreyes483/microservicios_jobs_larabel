import { reactive } from 'vue';

const state = reactive({
    service: [
        { baseUrl: 'https://orders-service.fly.dev/', token: 'token1' },
        { baseUrl: 'https://warehouse-ingredients-service.fly.dev/', token: 'token2' },
        { baseUrl: 'https://farmers-market-service.fly.dev/', token: 'token3' },
    ],
    selectedServiceIndex: 0,
});

export function updateServiceConfig(index, axios) {

    state.selectedServiceIndex = index;
    // Actualizar la URL base y el token en función del índice
    const { baseUrl } = state.service[index];
    const tokenKey = `access_token_${index}`;
    const token = localStorage.getItem(tokenKey) || '';
    axios.defaults.baseURL = baseUrl;
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

export function getUrl(index) {
    return state.service[index];
}

export function getImageUrl(index, filename) {
    return `${state.service[index].baseUrl}api/images/${filename}`;
}


