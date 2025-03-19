<template>
    <div class="p-2">
        <nav aria-label="breadcrumb card">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-black">Available Services</a></li>
        </ol>
        </nav>
        <!-- filter -->
        <div class="card px-4  py-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="filter row align-items-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date-of-filing" class="form-label w-50">From:</label>
                                <input type="date" id="date-of-filing" class="form-control" v-model="transact_date1" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                    <label for="date-of-filing" class="form-label w-50">To:</label>
                                    <input type="date" id="date-of-filing" class="form-control" v-model="transact_date2" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                    <label for="filter_name" class="form-label w-50">Service Name</label>
                                    <input type="text" id="filter_name" class="form-control" v-model="filter_name" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary w-100 mt-3 bg-blue" v-on:click="filterData()"> <i class="fas fa-filter"></i> Filter</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn w-100 mt-3 bg-yellow" style="color:white!important" v-on:click="showAppliedServices()" v-if="!showServicesApplied"> <i class="fas fa-window-maximize"></i>  Show Applied Services</button>
                            <button class="btn w-100 mt-3 bg-yellow" style="color:white!important" v-on:click="showData()" v-if="showServicesApplied"> <i class="fas fa-window-maximize"></i>  Show Services</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- content --> 
         <div style="height: 650px; overflow-y: scroll;overflow-x: hidden;" >
            <div class="row" v-show="!showServicesApplied">
                <div v-if="list.length == 0" class="d-flex justify-content-center w-100">
                    <p class="text-center p-3">No Item to show</p>
                </div>
                <div class="col-md-4" v-for="item in list">  
                    <div class="card p-3" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;">
                        <div class="card-header p-3 d-flex justify-content-between">
                            <div class="w-75">
                                <p class="text-bold m-0 p-0">{{ item.name  }}</p>
                                <p class="m-0 p-0 text-secondary">{{ item.government_program_id ? 'Government Programs' : 'Service'}}</p>
                                <p class="m-0 p-0 text-secondary">Creation Date: {{ formatDate(item.created_at)}}  </p>
                                <p class="m-0 p-0 text-secondary"> {{ item.government_program_id ? 'Program Duration' : 'Service Duration'}} : {{ formatDate(item.start_date) }} - {{  formatDate(item.end_date) }}  </p>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <article class="p-3">
                                {{ item.description }}
                            </article>
                        </div>
                        <div class="card-footer p-3">
                            <button class="btn btn-outline-primary w-100" v-on:click="apply(item)">Apply for this {{ item.government_program_id ? ' Program' : ' Service'}} </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-show="showServicesApplied">
                <div v-if="serviceApplied.length == 0" class="d-flex justify-content-center w-100">
                    <p class="text-center p-3">No Item to show</p>
                </div>
                <div v-else>
                    <p class=" p-3">Applied Services</p>
                    <div class="col-md-4" v-for="item in serviceApplied">  
                        <div class="card p-3" style="box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;">
                            <div class="card-header p-3 d-flex justify-content-between">
                                <div class="w-75">
                                    <p class="text-bold m-0 p-0">{{ item.name  }}</p>
                                    <p class="m-0 p-0 text-secondary">{{ item.government_program_id ? 'Government Programs' : 'Service'}}</p>
                                    <p class="m-0 p-0 text-secondary">Creation Date: {{ formatDate(item.created_at)}}  </p>
                                    <p class="m-0 p-0 text-secondary"> {{ item.government_program_id ? 'Program Duration' : 'Service Duration'}} : {{ formatDate(item.start_date) }} - {{  formatDate(item.end_date) }}  </p>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <article class="p-3">
                                    {{ item.description }}
                                </article>
                            </div>
                            <div class="card-footer p-3">
                                <button class="btn btn-outline-danger w-100" v-on:click="cancel(item)">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>

        

        <!-- preloader -->
        <div class="vld-parent" style="z-index: 9999!important;">
        <loading v-model:active="isLoading"
                :is-full-page="fullPage"/>
        </div>
  </div>
</template>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default{
  components: {
    Loading
  },
  data(){
    return {
        isLoading: false,
        fullPage: true,
        isEdit : false,
        showServicesApplied : false,
        errors : [],

        filter_opening_type : '',
        filter_name : '',
        // Set dafault date form start of the month to date today
        transact_date1 : new Date(new Date().getFullYear(), new Date().getMonth(), 1).toLocaleDateString('en-CA'),
        transact_date2 :new Date().toLocaleDateString('en-CA'),

        opening_type : '',
        selectedItem : [],
        data : [],
        list : [],
        applicant_list : [],
        serviceApplied : [],
        has_personal_info : false,

        start_date : '',
        end_date : '',

        data: [],
        columns: ['id', 'name', 'adddress', 'group', 'date_applied'],
        options: {
        headings: {
          id: 'ID',
          name: 'Fullname',
          adddress: 'Address',
          group: 'Group',
          date_applied : 'Date Applied',
        },
        filterable: false,
        perPageValues: [], // Hides the dropdown
      },
      
    }
  },
  methods: {
    init() {
        this.opening_type = '';
        this.selectedItem = [];
    },
    formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
    },
    showData(){
        this.showServicesApplied = false;
        axios.get('/web_services/show').then(response => {
            this.list = response.data.data;
            this.has_personal_info = response.data.has_personal_info;
        });
    },
    filterData(){
        const obj = {
            filter_opening_type : this.filter_opening_type,
            date_from : this.transact_date1,
            date_to : this.transact_date2,
        };
        axios.post('/web_services/filter',  obj).then(response => {
            this.list = response.data.data;
        }).catch(error => {
            console.log(error);
        })
    },
    apply(item){
        console.log(item);
        if(!this.has_personal_info){
            this.$fire({
                title : 'INFORMATION',
                text : 'Please fill up your profile information first!',
                type : 'info',
                timer : 3000,
            });
            return false;
        }

        if(confirm('Apply for this service?')) {
        axios.get('/web_services/apply/' + item.id)
        .then(response => {
            // console.log(response);
            this.$fire({
                title : 'Successfully Applied!',
                text : response.data.message,
                type : 'success',
                timer : 3000,
            }).then( r => {
                console.log("test");
            })
            this.showData();
        }).catch(error => {
            if(error.response.status == 500){
                this.$fire({
                    title : 'Error',
                    text : 'Internal Server Error',
                    type : 'warning',
                    timer : 3000,
                })
            }
        this.errors = error.response.data.errors;
        });
        }
    },
    showAppliedServices(){
        this.showServicesApplied = true;
        this.isLoading = true;
        axios.get('/web_services/servicesapplied').then(response => {
            this.serviceApplied = response.data.data;
        }).catch(error => {
            this.$fire({
                title : 'Error',
                text :  error.response.data.errors,
                type : 'warning',
                timer : 3000,
            })
        }).finally(() => {this.isLoading = false});
    },
    cancel(item){
        this.isLoading = true;
        axios.get('/web_services/cancelappliedservice/' + item.id).then(response => {
            this.$fire({
                title : 'Cancelled!',
                text : response.data.message,
                type : 'success',
                timer : 3000,
            }).then( r => {
                console.log("test");
            });
            this.showAppliedServices();
        }).catch(error => {
            this.$fire({
                title : 'Error',
                text :  error.response.data.errors,
                type : 'warning',
                timer : 3000,
            })
        }).finally(() => {this.isLoading = false});
    }
 
   
  
    },
    mounted() {
        this.showData();
    }
}

</script>

<style scoped>
.p-5 {
    padding: 3rem !important;
}

.card {
    margin-top: 1rem;
    box-shadow: rgba(0, 0, 0, 0.09) 0px 3px 12px;
    border-radius: 10px;
}


.card-body {
    padding: 0!important;
}

.filter p,.filter button {
  font-size: 14px;
}

.breadcrumb {
    background-color: white;
    font-size: 16px;
    font-weight: bold;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '/';
    color: #6c757d;
    padding: 0 0.5rem;
}
</style>
