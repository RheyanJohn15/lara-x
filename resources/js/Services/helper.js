export const help = {
    dataBuilder: (params, data)=> {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let build = {};

        build._token = csrfToken;

        for(let i = 0; i < params.length; i++){
            build[params[i]] = data[i];
        }

        return build;
    }
}

export function isAuthenticated() {
    const token = localStorage.getItem('api_token');

    return token !== null;
}
