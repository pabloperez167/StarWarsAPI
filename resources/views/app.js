
import axios from 'axios';

new Vue({
    el: '#app',
    data: {
        starships: []
    },
    mounted() {
        this.getStarships();
    },
    methods: {
        getStarships() {
            // Realizar una solicitud HTTP para obtener los datos de las naves y pilotos desde la API
            axios.get('/api/Starship')
                .then(response => {
                    this.starships = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
});
  