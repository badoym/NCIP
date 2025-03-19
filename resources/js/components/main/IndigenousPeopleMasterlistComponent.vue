<template>
    <div class="p-2">
      <nav aria-label="breadcrumb card">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#" class="text-black">Indigenous People Masterlist</a>
          </li>
        </ol>
      </nav>
      <div class="row">
        <div class="col-md-12">
          <div class="card p-5" style="height: 83vh; overflow-y: scroll;">
            <div class="filter row align-items-center">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date-of-filing" class="form-label w-50">Date From:</label>
                  <input type="date" id="date-of-filing" class="form-control" v-model="transact_date1" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="date-of-filing" class="form-label w-50">Date To:</label>
                  <input type="date" id="date-of-filing" class="form-control" v-model="transact_date2" />
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="region" class="form-label w-50">Name</label>
                  <input type="text" id="region" class="form-control" v-model="filter_name">
                </div>
              </div>
              <div class="col-md-3">
                <button class="btn btn-primary w-100 mt-3" v-on:click="filterData()">
                  <i class="fas fa-filter"></i> Filter </button>
              </div>
            </div>
            <v-client-table :data="data" :columns="columns" :options="options">
              <template slot="actions" slot-scope="row">
                <button class="btn btn-outline-primary" v-on:click="view(row)">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-outline-success" v-on:click="approve(row)">
                  <i class="fas fa-thumbs-up"></i>
                </button>
                <button class="btn btn-outline-danger" v-on:click="reject(row)">
                  <i class="fas fa-thumbs-down"></i>
                </button>
              </template>
              <template slot="status" slot-scope="row">
                        <span 
                            :class="row.row.is_verified == 0 || row.row.is_verified == null ? 'text-danger' : 'text-success'"
                            class="font-bold"
                        >
                            ●
                        </span> 
                        {{ row.row.is_verified== 0  || row.row.is_verified == null ?  'Not Verified' : 'Verified' }}
              </template>
            </v-client-table>
          </div>
        </div>
      </div>
      <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl p-3" role="document">
          <div class="modal-content">
            <h5 class="modal-title text-center bg-light  pt-4 pb-2" style="font-weight:bold;">User Personal Information</h5>
            <div class="modal-body " style="height: 700px; overflow-y:auto">
              <div class="row p-4">
                <div class="col-md-3 my-4">
                  <h3 style="text-align: left;">PERSONAL INFORMATION</h3>
                </div>
                <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                  <div class="p-2">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" class="form-control" v-model="name" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="alias">Other name/Alias (if any)</label>
                          <input type="text" class="form-control" v-model="alias" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="gender">Sex/Gender</label>
                          <select name="gender" id="gender" class="form-control" v-model="gender" readonly>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="P">Prefer not to say</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="civil_status">Civil Status</label>
                          <select name="civil_status" id="civil_status" class="form-control" v-model="civil_status" readonly>
                            <option value="M">Single</option>
                            <option value="F">Married</option>
                            <option value="P">Widow/er</option>
                            <option value="P">Separated </option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="birthday">Birthday</label>
                          <input type="date" class="form-control" v-model="birthday" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="age">Age</label>
                          <input type="text" class="form-control" v-model="age" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="phone_number">Phone Number</label>
                          <input type="text" class="form-control" v-model="phone_number" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email_address">Email Address</label>
                          <input type="email" class="form-control" v-model="email_address" readonly>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="indigenous_group_id">Ethnicity</label>
                          <select name="indigenous_group_id" id="indigenous_group_id" class="form-control" v-model="indigenous_group_id" readonly>
                            <option v-for="item in indigenous_group" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 my-4">
                  <h3 style="text-align: left; text-transform: uppercase;">ADDRESS</h3>
                </div>
                <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                  <div class="p-2">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="region_id">Region</label>
                          <select name="region_id" id="region_id" class="form-control" v-model="region_id" v-on:change="getProvincesByRegion(region_id)" readonly>
                            <option v-for="item in regions" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="province_id">Province</label>
                          <select name="province_id" id="province_id" class="form-control" v-model="province_id" v-on:change="getCitiesByProvince(province_id)" readonly>
                            <option v-for="item in provinces" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="city_id">City</label>
                          <select name="city_id" id="city_id" class="form-control" v-model="city_id" v-on:change="getBarangayByCities(city_id)" readonly>
                            <option v-for="item in cities" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="barangay_id">Barangay</label>
                          <select name="barangay_id" id="barangay_id" class="form-control" v-model="barangay_id" readonly>
                            <option v-for="item in barangays" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Address 2 <i>House no. / Phase</i>
                          </label>
                          <input type="text" class="form-control" v-model="address1" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="name">Address 2 <i>Block/Lot</i>
                          </label>
                          <input type="text" class="form-control" v-model="address2" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 my-4">
                  <h3 style="text-align: left; text-transform: uppercase;">FAMILY AND HOUSEHOLD INFORMATION</h3>
                </div>
                <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                  <div class="p-2">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label>Father’s Name:</label>
                          <input v-model="fatherName" type="text" class="form-control" readonly/>
                          <label class="mt-2">
                            <input v-model="fatherIndigenous" type="checkbox" disabled /> Indigenous </label>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Mother’s Name:</label>
                          <input v-model="motherName" type="text" class="form-control" readonly />
                          <label class="mt-2">
                            <input v-model="motherIndigenous" type="checkbox" disabled/> Indigenous </label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Spouse’s Name (if applicable):</label>
                          <input v-model="spouseName" type="text" class="form-control" readonly/>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Number of Children:</label>
                          <input v-model.number="numChildren" type="number" class="form-control" min="0" @input="updateChildrenList" readonly/>
                        </div>
                      </div>
                      <div class="col-md-12 my-2">
                        <div v-if="numChildren > 0">
                          <h3>Children's Details</h3>
                          <div class="row mt-3">
                            <div v-for="(child, index) in children" :key="index" class="form-group child-group col-md-3">
                              <label>Child {{ index + 1 }} Name:</label>
                              <input v-model="child.name" type="text" class="form-control my-2" readonly/>
                              <label>Age:</label>
                              <input v-model.number="child.age" type="number" class="form-control" min="0" readonly/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 my-4">
                  <h3 style="text-align: left; text-transform: uppercase;">INDIGENOUS GROUP AND ANCESTRAL DOMAIN INFORMATION</h3>
                </div>
                <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                  <div class="p-2">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="name">Indigenous Group / Tribe</label>
                          <input type="text" class="form-control" v-model="tribe_name" readonly>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="name">Ethnolinguistic Group (if applicable)</label>
                          <input type="text" class="form-control" v-model="ethno_group" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="birthday">Traditional Name (optional)</label>
                          <input type="text" class="form-control" v-model="traditional_name" readonly>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="settlement_name">Community / Village / Settlement Name</label>
                          <input type="text" class="form-control" v-model="settlement_name" readonly>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="ind_region_id">Region</label>
                          <select name="ind_region_id" id="ind_region_id" class="form-control" v-model="ind_region_id" v-on:change="ind_getProvincesByRegion(ind_region_id)" readonly>
                            <option v-for="item in regions" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="ind_province_id">Province</label>
                          <select name="ind_province_id" id="ind_province_id" class="form-control" v-model="ind_province_id" v-on:change="ind_getCitiesByProvince(ind_province_id)" readonly>
                            <option v-for="item in ind_provinces" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="ind_city_id">City</label>
                          <select name="ind_city_id" id="ind_city_id" class="form-control" v-model="ind_city_id" v-on:change="ind_getBarangayByCities(ind_city_id)" readonly>
                            <option v-for="item in ind_cities" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label for="ind_barangay_id">Barangay</label>
                          <select name="ind_barangay_id" id="ind_barangay_id" class="form-control" v-model="ind_barangay_id" readonly>
                            <option v-for="item in ind_barangays" :value="item.id">{{ item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="landmark">Landmark / Boundaries</label>
                          <input type="text" class="form-control" v-model="landmark" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 my-4">
                  <h3 style="text-align: left; text-transform: uppercase;">Community Role and Participation</h3>
                </div>
                <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                  <div class="p-2">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="form-label">Role in Indigenous Community:</label>
                          <input v-model="communityRole" type="text" class="form-control" placeholder="Elder, Leader, Healer, etc."readonly />
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Affiliation with Indigenous Organizations (if any):</label>
                          <input v-model="organizationAffiliation" type="text" class="form-control" readonly/>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Participation in Traditional Practices / Rituals:</label>
                          <textarea v-model="traditionalPractices" class="form-control" readonly></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 my-4">
                  <h3 style="text-align: left; text-transform: uppercase;">Socio-Economic Status</h3>
                </div>
                <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                  <div class="p-2">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="form-label">Primary Source of Income / Livelihood:</label>
                          <input v-model="livelihood" type="text" class="form-control" readonly/>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="form-label">Educational Attainment:</label>
                          <select v-model="education" class="form-control" readonly>
                            <option value="">Select</option>
                            <option value="No Formal Education">No Formal Education</option>
                            <option value="Primary">Primary</option>
                            <option value="Secondary">Secondary</option>
                            <option value="Higher Education">Higher Education</option>
                          </select>
                          <p class="text-danger" v-if="errors.education">{{ errors.education[0] }}</p>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Skills / Traditional Knowledge:</label>
                          <textarea v-model="skills" class="form-control" readonly></textarea >
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 my-4">
                  <h3 style="text-align: left; text-transform: uppercase;">Government Recognition and Support</h3>
                </div>
                <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                  <div class="p-2">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Membership in IP Organization / Council:</label>
                          <input v-model="ipOrganization" type="text" class="form-control" readonly/>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">Previous Government Assistance / Benefits Received:</label>
                          <textarea v-model="governmentAssistance" class="form-control" readonly></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="form-label">IP Mandatory Representative (IPMR) Status:</label>
                          <select v-model="ipmrStatus" class="form-control" readonly>
                            <option value="">Select</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center p-3" style="color: blue; cursor:pointer">
              <a v-on:click="closeModal">Close</a>
            </div>
          </div>
        </div>
      </div>
      <div class="vld-parent">
        <loading v-model:active="isLoading" :is-full-page="fullPage" />
      </div>
    </div>
  </template>
  <script>
    import Loading from 'vue-loading-overlay';
    import 'vue-loading-overlay/dist/vue-loading.css';
    export default {
      components: {
        Loading
      },
      data() {
        return {
          isLoading: false,
          fullPage: true,
          isEdit: false,
          errors: [],
          // Set dafault date form start of the month to date today
          transact_date1: new Date(new Date().getFullYear(), new Date().getMonth(), 1).toLocaleDateString('en-CA'),
          transact_date2: new Date().toLocaleDateString('en-CA'),
          selected_regions: '',
          filter_name: '',
          region_options: [],
          indigenous_group: [],
          regions: [],
          provinces: [],
          cities: [],
          barangays: [],
          ind_provinces: [],
          ind_cities: [],
          ind_barangays: [],
          id: '',
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          isPassword: false,
          data: [],
          columns: ['id', 'name', , 'email', 'status','actions'],
          options: {
            headings: {
              id: 'ID',
              name: 'Name',
              actions: 'Actions'
            },
            templates: {
              es_amount: function(h, row) {
                return Number(row.qty) * Number(row.unit_cost);
              }
            },
            filterable: false,
            perPageValues: [], // Hides the dropdown
          },
          name: '',
          gender: '',
          birthday: '',
          phone_number: '',
          indigenous_group_id: '',
          age: '',
          region_id: '',
          province_id: '',
          city_id: '',
          barangay_id: '',
          address1: '',
          address2: '',
          alias: '',
          civil_status: '',
          phone_number: '',
          email_address: '',
          traditional_name: '',
          settlement_name: '',
          tribe_name: '',
          ethno_group: '',
          traditional_name: '',
          settlement_name: '',
          ind_region_id: '',
          ind_province_id: '',
          ind_city_id: '',
          ind_barangay_id: '',
          fatherName: '',
          fatherIndigenous: false,
          motherName: '',
          motherIndigenous: false,
          spouseName: '',
          numChildren: 0,
          children: [],
          communityRole: '',
          organizationAffiliation: '',
          traditionalPractices: '',
          livelihood: '',
          education: '',
          skills: '',
          ipOrganization: '',
          governmentAssistance: '',
          ipmrStatus: '',
          landmark: '',
        }
      },
      methods: {
        updateChildrenList() {
          let count = this.numChildren;
          this.children = Array.from({
            length: count
          }, (_, i) => ({
            name: this.children[i]?.name || "",
            age: this.children[i]?.age || "",
          }));
        },
        init() {
          this.name = '';
          this.email = '';
          this.filter_name = '';
          this.errors = [];
          this.name = '';
          this.gender = '';
          this.birthday = '',
            this.phone_number = '';
          this.indigenous_group_id = '';
          this.age = '';
          this.region_id = '';
          this.province_id = '';
          this.city_id = '';
          this.barangay_id = '';
          this.address1 = '';
          this.address2 = '';
          this.alias = '';
          this.civil_status = '';
          this.phone_number = '';
          this.email_address = '';
          this.traditional_name = '';
          this.settlement_name = '';
          this.tribe_name = '';
          this.ethno_group = '';
          this.traditional_name = '';
          this.settlement_name = '';
          this.ind_region_id = '';
          this.ind_province_id = '';
          this.ind_city_id = '';
          this.ind_barangay_id = '';
          this.fatherName = '';
          this.fatherIndigenous = false;
          this.motherName = '';
          this.motherIndigenous = false;
          this.spouseName = '';
          this.numChildren = 0;
          this.children = [];
          this.communityRole = '';
          this.organizationAffiliation = '';
          this.traditionalPractices = '';
          this.livelihood = '';
          this.education = '';
          this.skills = '';
          this.ipOrganization = '';
          this.governmentAssistance = '';
          this.ipmrStatus = '';
          this.landmark = '';
        },
        show() {
          this.isLoading = true;
          axios.get('/ipmasterlist/show').then(function(res) {
            this.data = res.data.data;
            this.indigenous_group = res.data.indigenous_group;
            this.regions = res.data.regions;
          }.bind(this)).finally(() => {
            this.isLoading = false
          });
        },
        closeModal() {
          $("#view-modal").modal("hide");
        },
        create() {
          this.isEdit = false;
          this.isPassword = false;
          this.init();
          $("#view-modal").modal("show");
        },
        filterData() {
          this.isLoading = true;
          axios.post('/ipmasterlist/filterData', {
            date_from: this.transact_date1,
            date_to: this.transact_date2,
            name: this.filter_name
          }).then(response => {
            this.data = response.data.data;
          })
        },
        createRecord() {
          this.isLoading = true;
          axios.post('/ipmasterlist/store', {
            name: this.name,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation,
          }).then(response => {
            this.$fire({
              title: 'Successfully Saved!',
              text: response.data.message,
              type: 'success',
              timer: 3000,
            })
            this.show();
            this.init();
            this.closeModal();
          }).catch(error => {
            this.$fire({
              title: 'Error Saving',
              text: error.response.data.message,
              type: 'warning',
              timer: 3000,
            })
            this.isLoading = false;
            this.errors = error.response.data.errors;
          }).finally(() => {
            this.isLoading = false
          })
        },
        edit(data) {
          this.isEdit = true;
          this.isPassword = false;
          this.id = data.row.id;
          this.name = data.row.name;
          this.email = data.row.email;
          $("#view-modal").modal("show");
        },
        view(item) {
          this.isLoading = true;
          this.init();
          axios.get('/ipmasterlist/view/' + item.row.id).then(response => {
            if (response.data.data != null) {
              this.name = response.data.data.name;
              this.gender = response.data.data.gender;
              this.birthday = response.data.data.birthday;
              this.phone_number = response.data.data.phone_number;
              this.indigenous_group_id = response.data.data.indigenous_group_id;
              this.age = response.data.data.age;
              this.region_id = response.data.data.region_id;
              this.province_id = response.data.data.province_id;
              this.city_id = response.data.data.city_id;
              this.barangay_id = response.data.data.barangay_id;
              this.address1 = response.data.data.address1;
              this.address2 = response.data.data.address2;
              this.alias = response.data.data.alias;
              this.civil_status = response.data.data.civil_status;
              this.phone_number = response.data.data.phone_number;
              this.email_address = response.data.data.email_address;
              this.traditional_name = response.data.data.traditional_name;
              this.settlement_name = response.data.data.settlement_name;
              this.tribe_name = response.data.data.tribe_name;
              this.ethno_grouptribe_name = response.data.data.ethno_grouptribe_name;
              this.traditional_nametribe_name = response.data.data.traditional_nametribe_name;
              this.settlement_nametribe_name = response.data.data.settlement_nametribe_name;
              this.ind_region_id = response.data.data.ind_region_id;
              this.ind_province_id = response.data.data.ind_province_id;
              this.ind_city_id = response.data.data.ind_city_id;
              this.ind_barangay_id = response.data.data.ind_barangay_id;
              this.fatherName = response.data.data.fatherName;
              this.fatherIndigenous = response.data.data.fatherIndigenous;
              this.motherName = response.data.data.motherName;
              this.motherIndigenous = response.data.data.motherIndigenous;
              this.spouseName = response.data.data.spouseName;
              this.numChildren = response.data.data.numChildren;
              this.children = response.data.data.children;
              this.communityRole = response.data.data.communityRole;
              this.organizationAffiliation = response.data.data.organizationAffiliation;
              this.traditionalPractices = response.data.data.traditionalPractices;
              this.livelihood = response.data.data.livelihood;
              this.education = response.data.data.education;
              this.skills = response.data.data.skills;
              this.ipOrganization = response.data.data.ipOrganization;
              this.governmentAssistance = response.data.data.governmentAssistance;
              this.ipmrStatus = response.data.data.ipmrStatus;
              this.tribe_name = response.data.data.tribe_name;
              this.ethno_group = response.data.data.ethno_group;
              this.traditional_name = response.data.data.traditional_name;
              this.settlement_name = response.data.data.settlement_name;
              this.landmark = response.data.data.landmark;
              this.getProvincesByRegion(this.region_id);
              this.getCitiesByProvince(this.province_id);
              this.getBarangayByCities(this.city_id);
              this.ind_getProvincesByRegion(this.ind_region_id);
              this.ind_getCitiesByProvince(this.ind_province_id);
              this.ind_getBarangayByCities(this.ind_city_id);
              $("#view-modal").modal("show");
            } else {
              this.$fire({
                title: 'Information',
                text: 'Unfortunately this user has not yet input his/her information',
                type: 'info',
                timer: 3000,
              })
            }
          }).catch(error => {
            this.$fire({
              title: 'Error Saving',
              text: error.response.data.message,
              type: 'warning',
              timer: 3000,
            })
            this.isLoading = false;
            this.errors = error.response.data.errors;
          }).finally(() => {
            this.isLoading = false
          })
        },
        async getProvincesByRegion(region_id) {
          await axios.get('barangays/getProvincesByRegion/' + region_id).then(response => {
            this.provinces = response.data.provinces;
          }).catch(error => {
            console.error('Error fetching provinces:', error);
          });
        },
        async getCitiesByProvince(province_id) {
          await axios.get('barangays/getCitiesByProvince/' + province_id).then(response => {
            this.cities = response.data.cities;
          }).catch(error => {
            console.error('Error fetching cities:', error);
          });
        },
        async getBarangayByCities(city_id) {
          await axios.get('barangays/getBarangayByCities/' + city_id).then(response => {
            this.barangays = response.data.barangays;
          }).catch(error => {
            console.error('Error fetching barangays:', error);
          });
        },
        async ind_getProvincesByRegion(region_id) {
          await axios.get('barangays/getProvincesByRegion/' + region_id).then(response => {
            this.ind_provinces = response.data.provinces;
          }).catch(error => {
            console.error('Error fetching provinces:', error);
          });
        },
        async ind_getCitiesByProvince(province_id) {
          await axios.get('barangays/getCitiesByProvince/' + province_id).then(response => {
            this.ind_cities = response.data.cities;
          }).catch(error => {
            console.error('Error fetching cities:', error);
          });
        },
        async ind_getBarangayByCities(city_id) {
          await axios.get('barangays/getBarangayByCities/' + city_id).then(response => {
            this.ind_barangays = response.data.barangays;
          }).catch(error => {
            console.error('Error fetching barangays:', error);
          });
        },
        approve(data){
          console.log(data);

          if(data.row.user_information_id != null){
            axios.get('/ipmasterlist/action/' + data.row.user_information_id  + '/' + 1).then(response =>{
              this.$fire({
                title : 'Success!',
                text : response.data.message,
                type : 'success',
                timer : 3000,
              });
              this.show();
            })
          }else{
            this.$fire({
                title: 'Cannot be approve',
                text: 'Unfortunately this user has not yet input his/her information',
                type: 'info',
                timer: 3000,
              })
          }
        },
        reject(data){
          if(data.row.user_information_id != null){
            axios.get('/ipmasterlist/action/' + data.row.user_information_id + '/' + 0).then(response =>{
              this.$fire({
                title : 'Success!',
                text : response.data.message,
                type : 'success',
                timer : 3000,
              });
              this.show();
            })
          }else{
            this.$fire({
                title: 'Cannot be approve',
                text: 'Unfortunately this user has not yet input his/her information',
                type: 'info',
                timer: 3000,
              })
          }
        }
      },
      mounted() {
        this.isLoading = false;
        this.show();
        this.init();
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
      padding: 0 !important;
    }
  
    .form-group {
      margin-bottom: 1rem;
    }
  
    .form-check {
      margin-top: 0.5rem;
    }
  
    .filter p,
    .filter button {
      font-size: 14px;
    }
  
    .breadcrumb {
      background-color: white;
      font-size: 16px;
      font-weight: bold;
    }
  
    .breadcrumb-item+.breadcrumb-item::before {
      content: '/';
      color: #6c757d;
      padding: 0 0.5rem;
    }
  </style>