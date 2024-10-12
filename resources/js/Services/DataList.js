export const UITech = {
    getUiTechData() {
        return [
            {
                id: '1000',
                code: 'f230fh0g3',
                name: 'HTML/JS/CSS Vanilla',
                description: 'Product Description',
                image: 'frontend_tech.png',
                price: 65,
                category: 'Accessories',
                quantity: 24,
                inventoryStatus: 'INSTOCK',
                rating: 5
            },
            {
                id: '1001',
                code: 'nvklal433',
                name: 'Bootstrap CSS Framework',
                description: 'Bootstrap',
                image: 'bootstrap.png',
                price: 72,
                category: 'Accessories',
                quantity: 61,
                inventoryStatus: 'INSTOCK',
                rating: 4
            },
            {
                id: '1002',
                code: 'zz21cz3c1',
                name: 'Tailwind CSS Framework',
                description: 'Tailwind CSS Framework',
                image: 'tailwind.png',
                price: 79,
                category: 'Fitness',
                quantity: 2,
                inventoryStatus: 'LOWSTOCK',
                rating: 3
            },
            {
                id: '1003',
                code: '244wgerg2',
                name: 'Blue T-Shirt',
                description: 'vue.png',
                image: 'vue.png',
                price: 29,
                category: 'Clothing',
                quantity: 25,
                inventoryStatus: 'INSTOCK',
                rating: 5
            },
        ];
    },

 
    getData() {
        return Promise.resolve(this.getUiTechData());
    },
};

