function existToken(){
    const token0 = localStorage.getItem('access_token_0');
    const token1 = localStorage.getItem('access_token_1');
    const token2 = localStorage.getItem('access_token_2');

    //console.log('Token Status:', token0, token1, token2); 
    let  isToken = token0 && token0.trim() !== '' && token1 && token1.trim() !== '' && token2 && token2.trim() !== '';

    if (isToken) {
        return true
    }
    return false
}

export { existToken }