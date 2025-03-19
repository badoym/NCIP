<template>
    <div class="p-2" style="height: 94vh; overflow-y:auto;">
        <div class="p-5">
            <div class="flex justify-content-end text-right">
                <div>
                    <p>
                        Status: 
                        <span 
                            :class="status == 0 ? 'text-danger' : 'text-success'"
                            class="font-bold"
                        >
                            ●
                        </span> 
                        {{ status == 0  ? 'Not Verified' : 'Verified' }}
                    </p>
                </div>
            </div>
            <div class="row ">
            <div class="col-md-3 my-4">
                <h3 style="text-align: left;">PERSONAL INFORMATION</h3>
            </div>
            <div class="col-md-9 p-4 bg-white my-4" style="box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px; border-radius: 10px;">
                <div class="p-2">
                    <div class="row">
                        <div class="col-md-8">  
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="name">
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                                <label for="alias">Other name/Alias (if any)</label>
                                <input type="text" class="form-control" v-model="alias">
                            </div>
                        </div>
                        <div class="col-md-3">  
                            <div class="form-group">
                                <label for="gender">Sex/Gender</label>
                                <select name="gender" id="gender" class="form-control" v-model="gender">
                                    <option value="M">Male</option>
                                    <option value="F">Female</option>
                                    <option value="P">Prefer not to say</option>
                                </select>
                                <p class="text-danger" v-if="errors.gender">{{ errors.gender[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">  
                            <div class="form-group">
                                <label for="civil_status">Civil Status</label>
                                <select name="civil_status" id="civil_status" class="form-control" v-model="civil_status">
                                    <option value="M">Single</option>
                                    <option value="F">Married</option>
                                    <option value="P">Widow/er</option>
                                    <option value="P">Separated </option>
                                </select>
                                <p class="text-danger" v-if="errors.civil_status">{{ errors.civil_status[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="birthday">Birthday</label>
                                <input type="date" class="form-control" v-model="birthday">
                                <p class="text-danger" v-if="errors.birthday">{{ errors.birthday[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="text" class="form-control" v-model="age">
                                <p class="text-danger" v-if="errors.age">{{ errors.age[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" v-model="phone_number">
                                <p class="text-danger" v-if="errors.phone_number">{{ errors.phone_number[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email_address">Email Address</label>
                                <input type="email" class="form-control" v-model="email_address">
                                <p class="text-danger" v-if="errors.email_address">{{ errors.email_address[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="indigenous_group_id">Ethnicity</label>
                                <select name="indigenous_group_id" id="indigenous_group_id" class="form-control" v-model="indigenous_group_id">
                                    <option v-for="item in indigenous_group" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.indigenous_group_id">{{ errors.indigenous_group_id[0] }}</p>

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
                                <select name="region_id" id="region_id" class="form-control" v-model="region_id"  v-on:change="getProvincesByRegion(region_id)">
                                    <option v-for="item in regions" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.region_id">{{ errors.region_id[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="province_id">Province</label>
                                <select name="province_id" id="province_id" class="form-control" v-model="province_id" v-on:change="getCitiesByProvince(province_id)">
                                    <option v-for="item in provinces" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.province_id">{{ errors.province_id[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="form-control" v-model="city_id" v-on:change="getBarangayByCities(city_id)">
                                    <option v-for="item in cities" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.city_id">{{ errors.city_id[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="barangay_id">Barangay</label>
                                <select name="barangay_id" id="barangay_id" class="form-control" v-model="barangay_id">
                                    <option v-for="item in barangays" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.barangay_id">{{ errors.barangay_id[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Address 2 <i>House no. / Phase</i></label>
                                <input type="text" class="form-control" v-model="address1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Address 2 <i>Block/Lot</i></label>
                                <input type="text" class="form-control"  v-model="address2">
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
                                <input v-model="fatherName" type="text" class="form-control" />
                                <label class="mt-2">
                                    <input v-model="fatherIndigenous" type="checkbox" />
                                    Indigenous
                                </label>
                                <p class="text-danger" v-if="errors.fatherName">{{ errors.fatherName[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                                <label>Mother’s Name:</label>
                                <input v-model="motherName" type="text" class="form-control" />
                                <label class="mt-2">
                                    <input v-model="motherIndigenous" type="checkbox" />
                                    Indigenous
                                </label>
                                <p class="text-danger" v-if="errors.motherName">{{ errors.motherName[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Spouse’s Name (if applicable):</label>
                                <input v-model="spouseName" type="text" class="form-control" />
                            </div>
                        </div>
<!-- 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Number of Children:</label>
                                <input
                                    v-model.number="numChildren"
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    @input="updateChildrenList"
                                />
                            </div>
                        </div>

                        <div class="col-md-12 my-2">
                            <div v-if="numChildren > 0">
                                <h3>Children's Details</h3>
                                <div class="row mt-3">
                                    <div
                                        v-for="(child, index) in children"
                                        :key="index"
                                        class="form-group child-group col-md-3"
                                    >
                                        <label>Child {{ index + 1 }} Name:</label>
                                        <input v-model="child.name" type="text" class="form-control my-2" />
                                        <label>Age:</label>
                                        <input v-model.number="child.age" type="number" class="form-control" min="0" />
                                    </div>
                                </div>
                               
                            </div>
                        </div> -->
                    
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
                                <input type="text" class="form-control" v-model="tribe_name">
                                <p class="text-danger" v-if="errors.tribe_name">{{ errors.tribe_name[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                                <label for="name">Ethnolinguistic Group (if applicable)</label>
                                <input type="text" class="form-control" v-model="ethno_group">
                                <p class="text-danger" v-if="errors.ethno_group">{{ errors.ethno_group[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthday">Traditional Name (optional)</label>
                                <input type="text" class="form-control" v-model="traditional_name">
                                <p class="text-danger" v-if="errors.traditional_name">{{ errors.traditional_name[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="settlement_name">Community / Village / Settlement Name</label>
                                <input type="text" class="form-control" v-model="settlement_name">
                                <p class="text-danger" v-if="errors.settlement_name">{{ errors.settlement_name[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ind_region_id">Region</label>
                                <select name="ind_region_id" id="ind_region_id" class="form-control" v-model="ind_region_id"  v-on:change="ind_getProvincesByRegion(ind_region_id)">
                                    <option v-for="item in regions" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.ind_region_id">{{ errors.ind_region_id[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ind_province_id">Province</label>
                                <select name="ind_province_id" id="ind_province_id" class="form-control" v-model="ind_province_id" v-on:change="ind_getCitiesByProvince(ind_province_id)">
                                    <option v-for="item in ind_provinces" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.ind_province_id">{{ errors.ind_province_id[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ind_city_id">City</label>
                                <select name="ind_city_id" id="ind_city_id" class="form-control" v-model="ind_city_id" v-on:change="ind_getBarangayByCities(ind_city_id)">
                                    <option v-for="item in ind_cities" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.ind_city_id">{{ errors.ind_city_id[0] }}</p>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ind_barangay_id">Barangay</label>
                                <select name="ind_barangay_id" id="ind_barangay_id" class="form-control" v-model="ind_barangay_id">
                                    <option v-for="item in ind_barangays" :value="item.id">{{ item.name}}</option>
                                </select>
                                <p class="text-danger" v-if="errors.ind_barangay_id">{{ errors.ind_barangay_id[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="landmark">Landmark / Boundaries</label>
                                <input type="text" class="form-control" v-model="landmark">
                                <p class="text-danger" v-if="errors.landmark">{{ errors.landmark[0] }}</p>
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
                                <input v-model="communityRole" type="text" class="form-control" placeholder="Elder, Leader, Healer, etc." />
                                <p class="text-danger" v-if="errors.communityRole">{{ errors.communityRole[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                                <label class="form-label">Affiliation with Indigenous Organizations (if any):</label>
                                <input v-model="organizationAffiliation" type="text" class="form-control" />
                                <p class="text-danger" v-if="errors.organizationAffiliation">{{ errors.organizationAffiliation[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Participation in Traditional Practices / Rituals:</label>
                                <textarea v-model="traditionalPractices" class="form-control"></textarea>
                                <p class="text-danger" v-if="errors.traditionalPractices">{{ errors.traditionalPractices[0] }}</p>
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
                                <input v-model="livelihood" type="text" class="form-control" />
                                <p class="text-danger" v-if="errors.livelihood">{{ errors.livelihood[0] }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">  
                            <div class="form-group">
                                <label class="form-label">Educational Attainment:</label>
                                <select v-model="education" class="form-control">
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
                                <textarea v-model="skills" class="form-control"></textarea>
                                <p class="text-danger" v-if="errors.skills">{{ errors.skills[0] }}</p>
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
                                <input v-model="ipOrganization" type="text" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12">  
                            <div class="form-group">
                                <label class="form-label">Previous Government Assistance / Benefits Received:</label>
                                <textarea v-model="governmentAssistance" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">IP Mandatory Representative (IPMR) Status:</label>
                                <select v-model="ipmrStatus" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-md-12">
                <div class="d-md-flex justify-content-end">
                        <button class="btn btn-outline-danger mx-2">Cancel</button>
                        <button class="btn btn-primary" v-on:click="updateInformation">Update</button>
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
import { get } from 'lodash';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default{
    props : ['indigenous_group', 'regions', 'user'],
  components: {
    Loading
  },
  data(){
    return {
        isLoading: false,
        fullPage: true,
        errors : [],
        
        user_information : [],
        provinces : [], 
        cities : [],
        barangays : [],
        ind_provinces : [],
        ind_cities : [],
        ind_barangays : [],
        status : '',

        name : '',
        gender : '',
        age : '',
        birthday : '',
        phone_number : '',
        indigenous_group_id : '',
        region_id : '',
        province_id : '',
        city_id : '',
        barangay_id : '',
        address1 : '',
        address2 : '',
        alias : '',
        civil_status : '',
        phone_number : '',
        email_address : '',
        traditional_name : '',
        settlement_name : '',
        tribe_name : '',
        ethno_group : '',
        traditional_name : '',
        settlement_name : '',
        ind_region_id : '',
        ind_province_id : '',
        ind_city_id : '',
        ind_barangay_id : '',
        fatherName: '',
        fatherIndigenous: false,
        motherName: '',
        motherIndigenous: false,
        spouseName: '',
        numChildren: 0,
        children: [],
        communityRole : '',
        organizationAffiliation : '',
        traditionalPractices : '',
        livelihood : '',
        education : '',
        skills : '',
        ipOrganization : '',
        governmentAssistance : '',
        ipmrStatus : '',
        landmark : '',
    }
  },
  methods: {
    updateChildrenList() {
      let count = this.numChildren;
      this.children = Array.from({ length: count }, (_, i) => ({
        name: this.children[i]?.name || "",
        age: this.children[i]?.age || "",
      }));
    },
    init() {
        this.name = this.user.name;
        this.gender = this.user_information ? this.user_information['gender'] : '';
        this.age =   this.user_information ? this.user_information['age'] : '';
        this.birthday = this.user_information ? this.user_information['birthday'] : '';
        this.phone_number =  this.user_information ? this.user_information['phone_number'] : '';
        this.indigenous_group_id =  this.user_information ? this.user_information['indigenous_group_id'] : '';
        this.region_id =  this.user_information ? this.user_information['region_id'] : '';
        this.province_id =  this.user_information ? this.user_information['province_id'] : '';
        this.city_id =  this.user_information ? this.user_information['city_id'] : '';
        this.barangay_id =  this.user_information ? this.user_information['barangay_id'] : '';
        this.address1 = this.user_information ? this.user_information['address1'] : '';
        this.address2 = this.user_information ? this.user_information['address2'] : '';
        this.alias = this.user_information ? this.user_information['alias'] : '';
        this.civil_status = this.user_information ? this.user_information['civil_status'] : '';
        this.phone_number = this.user_information ? this.user_information['phone_number'] : '';
        this.email_address = this.user_information ? this.user_information['email_address'] : '';
        this.traditional_name = this.user_information ? this.user_information['traditional_name'] : '';
        this.settlement_name = this.user_information ? this.user_information['settlement_name'] : '';
        this.ind_region_id = this.user_information ? this.user_information['ind_region_id'] : '';
        this.ind_province_id = this.user_information ? this.user_information['ind_province_id'] : '';
        this.ind_city_id = this.user_information ? this.user_information['ind_city_id'] : '';
        this.ind_barangay_id = this.user_information ? this.user_information['ind_barangay_id'] : '';
        this.fatherName = this.user_information ? this.user_information['fatherName'] : '';
        this.fatherIndigenous = this.user_information ? this.user_information['fatherIndigenous'] : false;
        this.motherName = this.user_information ? this.user_information['motherName'] : '';
        this.motherIndigenous = this.user_information ? this.user_information['motherIndigenous'] : false;
        this.spouseName = this.user_information ? this.user_information['spouseName'] : '';
        this.numChildren = this.user_information ? this.user_information['numChildren'] : '';
        this.children = this.user_information ? this.user_information['children'] : ''; // MAKE THIS ARRAY
        this.communityRole = this.user_information ? this.user_information['communityRole'] : '';
        this.organizationAffiliation = this.user_information ? this.user_information['organizationAffiliation'] : '';
        this.traditionalPractices = this.user_information ? this.user_information['traditionalPractices'] : '';
        this.livelihood = this.user_information ? this.user_information['livelihood'] : '';
        this.education = this.user_information ? this.user_information['education'] : '';
        this.skills = this.user_information ? this.user_information['skills'] : '';
        this.ipOrganization = this.user_information ? this.user_information['ipOrganization'] : '';
        this.governmentAssistance = this.user_information ? this.user_information['governmentAssistance'] : '';
        this.ipmrStatus = this.user_information ? this.user_information['ipmrStatus'] : '';
        this.tribe_name = this.user_information ? this.user_information['tribe_name'] : '';
        this.ethno_group = this.user_information ? this.user_information['ethno_group'] : '';
        this.traditional_name = this.user_information ? this.user_information['traditional_name'] : '';
        this.settlement_name = this.user_information ? this.user_information['settlement_name'] : '';
        this.landmark = this.user_information ? this.user_information['landmark'] : '';
     },

    show(){
        this.isLoading = true;
        axios.get('/web_profile/show').then(response => {
            this.user_information = response.data.data;
            this.init();
            if(this.user_information){

                if(this.user_information.is_verified == 0 ){
                    this.status = 0;
                }
                else{
                    this.status = 1;
                }
                this.getProvincesByRegion(this.region_id);
                this.ind_getProvincesByRegion(this.ind_region_id);

                this.getCitiesByProvince(this.province_id);
                this.ind_getCitiesByProvince(this.ind_province_id);

                this.getBarangayByCities(this.city_id);
                this.ind_getBarangayByCities(this.ind_city_id);
            }
            else{
                this.status = 0;
            }
          
        }).catch(error => {
            this.errors = error.response.data.errors;
        }).finally(() => { this.isLoading = false});
    },
    updateInformation(){
    
        const obj = {
            id : this.user_information ? this.user_information['id'] :  '',
            user_id : this.user.id,
            name :  this.name,
            gender :  this.gender,
            age :  this.age,
            birthday :  this.birthday,
            phone_number :  this.phone_number,
            indigenous_group_id :  this.indigenous_group_id,
            region_id :  this.region_id,
            province_id :  this.province_id,
            city_id :  this.city_id,
            barangay_id :  this.barangay_id,
            address1 :  this.address1,
            address2 :  this.address2,

            //new addition of information
            alias  : this.alias,
            civil_status  : this.civil_status,
            phone_number  : this.phone_number,
            email_address  : this.email_address,
            traditional_name : this.traditional_name,
            settlement_name : this.settlement_name,
            tribe_name : this.tribe_name,
            ethno_group : this.ethno_grouptribe_name,
            traditional_name : this.traditional_nametribe_name,
            settlement_name : this.settlement_nametribe_name,
            ind_region_id : this.ind_region_id,
            ind_province_id : this.ind_province_id,
            ind_city_id : this.ind_city_id,
            ind_barangay_id : this.ind_barangay_id,
            fatherName : this.fatherName,
            fatherIndigenous : this.fatherIndigenous,
            motherName : this.motherName,
            motherIndigenous : this.motherIndigenous,
            spouseName : this.spouseName,
            numChildren : this.numChildren,
            children : this.children,
            communityRole : this.communityRole,
            organizationAffiliation : this.organizationAffiliation,
            traditionalPractices : this.traditionalPractices,
            livelihood : this.livelihood,
            education : this.education,
            skills : this.skills,
            ipOrganization : this.ipOrganization,
            governmentAssistance : this.governmentAssistance,
            ipmrStatus : this.ipmrStatus,
            tribe_name : this.tribe_name,
            ethno_group : this.ethno_group,
            traditional_name : this.traditional_name,
            settlement_name : this.settlement_name,
            landmark : this.landmark,
        }

        this.isLoading = true;
        axios.post('/web_profile/store', obj).then(response => {
            this.$fire({
                title : 'Successfully Saved!',
                text : response.data.message,
                type : 'success',
                timer : 3000,
            });
            this.showData();
            this.init();
            $("#create-modal").modal("hide");
        }).catch(error => {
            this.errors = error.response.data.errors;
            this.$fire({
                title : 'Something went wrong!',
                text : 'Fill up all the fields',
                type : 'warning',
                timer : 3000,
            });
        }).finally(() => { this.isLoading = false});

    },

    async getProvincesByRegion(region_id) {
        await axios.get('barangays/getProvincesByRegion/' + region_id)
        .then(response => {
            this.provinces = response.data.provinces;
        })
        .catch(error => {
            console.error('Error fetching provinces:', error);
        });
    },

    async getCitiesByProvince(province_id) {
        await axios.get('barangays/getCitiesByProvince/' + province_id)
        .then(response => {
            this.cities = response.data.cities;
        })
        .catch(error => {
            console.error('Error fetching cities:', error);
        });
    },
    async getBarangayByCities(city_id) {
        await axios.get('barangays/getBarangayByCities/' + city_id)
        .then(response => {
            this.barangays = response.data.barangays;
        })
        .catch(error => {
            console.error('Error fetching barangays:', error);
        });
    },
    async ind_getProvincesByRegion(region_id) {
        await axios.get('barangays/getProvincesByRegion/' + region_id)
        .then(response => {
            this.ind_provinces = response.data.provinces;
        })
        .catch(error => {
            console.error('Error fetching provinces:', error);
        });
    },

    async ind_getCitiesByProvince(province_id) {
        await axios.get('barangays/getCitiesByProvince/' + province_id)
        .then(response => {
            this.ind_cities = response.data.cities;
        })
        .catch(error => {
            console.error('Error fetching cities:', error);
        });
    },
    async ind_getBarangayByCities(city_id) {
        await axios.get('barangays/getBarangayByCities/' + city_id)
        .then(response => {
            this.ind_barangays = response.data.barangays;
        })
        .catch(error => {
            console.error('Error fetching barangays:', error);
        });
    },
    
    },
    mounted() {
        this.show();
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
