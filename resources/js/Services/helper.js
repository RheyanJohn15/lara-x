export const help = {
    //Create a data object for form query with csrf token
    dataBuilder: (params, data)=> {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let build = {};

        build._token = csrfToken;

        for(let i = 0; i < params.length; i++){
            build[params[i]] = data[i];
        }

        return build;
    },
    //Hide or unhide elements
    hide: (id, status) => {
        if(status){
            document.getElementById(id).classList.add('hidden');
        }else{
            document.getElementById(id).classList.remove('hidden');
        }
    },
    //Parse data and display toast for query return
    parseData: (data, toast) => {

        let severity = 'error';

        if(data.success){
            severity = 'success'
        }

        toast.add({ severity: severity, summary: data.method, detail: data.message, life: 3000 });
    }
}

export async function isAuthenticated() {
    const check = await fetch('/api/get/auth/checkauth', {
        method: "GET",
        headers: {"Content-Type": "application/json"},
    });

    const response = await check.json();

    if(response.data){
        return true;
    }

    return false;
}
