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

export async function isAuthenticated() {
    const check = await fetch('/api/get/auth/checkauth/null', {
        method: "GET",
        headers: {"Content-Type": "application/json"},
    });

    const response = await check.json();

    if(response.data){
        return true;
    }

    return false;
}
