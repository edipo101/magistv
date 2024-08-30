<template>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSearch">Buscar</button>

        <div id="modalSearch" class="modal fade" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-body">
                  <input v-model="search" type="search" class="form-control" placeholder="Buscar..." />
                  <h6 v-if="devices.length > 0" class="my-2">Devices:</h6>
                  <div class="list-group">
                     <div v-for="device in devices" :key="device.id">
                        <a href="#" class="list-group-item list-group-item-action">{{ device.name}}; {{ device.phone }}</a>
                     </div>
                  </div>
                  <h6 v-if="accounts.length > 0" class="my-2">Accounts:</h6>
                  <div class="list-group">
                     <div v-for="account in accounts" :key="account.id">
                        <a href="#" class="list-group-item list-group-item-action">{{ account.username}}</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            search: "",
            devices: [],
            accounts: []
        };
    },
    mounted() {
        this.fetchDevices();
    },
    watch: {
        search: function () {
            if (this.search.length < 3) {
               this.devices = [];
               this.accounts = [];
            }
            else
               this.fetchDevices();
        },
    },
    methods: {
        fetchDevices() {
            axios
                .get("http://localhost:8000/fetch-devices?s=" + this.search)
                .then((response) => {
                    this.devices = response.data.devices;
                    this.accounts = response.data.accounts;
                    console.log(response.data);
                });
        },
    },
};
</script>
