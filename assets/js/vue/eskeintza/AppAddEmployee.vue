<template>
    <div>
        <h2>Gehitu hautagaiak eskeintzarara:</h2>
        <hr>
        <button class="btn btn-primary btn-lg" @click="saveAndContinue"><i class="far fa-save"></i>&nbsp;Gorde eta jarraitu</button>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cmbZerrendak">Zerrendak</label>
                    <select :value="selectedZerrendaId" @input="changeZerrendaId" id="cmbZerrendak" class="custom-select">
                        <option value="-1">Aukeratu bat</option>
                        <option v-for="zerrenda in zerrendak" v-bind:value="zerrenda.id">{{zerrenda.name}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="cmbTypes">Egoera mota</label>
                    <select :value="selectedTypeId" @input="changeTypeId" id="cmbTypes" class="custom-select">
                        <option value="-1">Aukeratu bat</option>
                        <option v-for="type in types" v-bind:value="type.id">{{type.name}}</option>
                    </select>
                </div>
            </div>
        </div>


        <hr>
        <div class="row">
            <div class="col-md-6">
                <EmployeeTable  :use-for="'selection'"></EmployeeTable>
            </div>
            <div class="col-md-6">
                <EmployeeTable  :use-for="'selected'"></EmployeeTable>
            </div>
        </div>

    </div>

</template>

<script>
    import axios from "axios";
    import EmployeeTable from "./component/EmployeeTable";

    export default {
        name: 'app',
        components: {
            EmployeeTable
        },
        data() {
            return {
                job: null,
                jobDetails: [],
                types: [],
                selectedTypeId: "-1",
                selectedZerrendaId: "-1",
                selectEmployee: null,
                employeeList: [],
                zerrendak: [],
                employees: []
            }
        },
        mounted() {
            let el = document.querySelector("div[data-job]");
            this.job = JSON.parse(el.dataset.job);

            el = document.querySelector("div[data-jobDetails]");
            this.jobDetails = JSON.parse(el.dataset.jobdetails);

            el = document.querySelector("div[data-types]");
            this.types = JSON.parse(el.dataset.types);

            el = document.querySelector("div[data-zerrendak]");
            this.zerrendak = JSON.parse(el.dataset.zerrendak);

            this.$store.commit("MUTATION_SET_JOBID", this.job.id);
            // this.$store.dispatch("INITIAL_SELECTED_EMPLOYEE", this.jobDetails);
            this.$store.dispatch('ACTION_GET_JOB', this.job.id)
        },
        computed: {
          employeesList() {
              return this.employees
          }
        },
        methods: {
            changeTypeId: function(e) {
                this.selectedTypeId = e.target.value;
                const payload = {
                    typeid: this.selectedTypeId,
                    zerrendaid: this.selectedZerrendaId
                };
                this.$store.dispatch("ACTION_GET_EMPLOYEELIST", payload);
            },
            changeZerrendaId: function (e) {
                this.selectedZerrendaId = e.target.value;
                console.log('changeZerrendaId');
                const payload = {
                    typeid: this.selectedTypeId,
                    zerrendaid: this.selectedZerrendaId
                };
                this.$store.dispatch("ACTION_GET_EMPLOYEELIST", payload);
            },
            changeEmployeeSelect: function (e) {
                console.log("Employee select");
                console.log(e);
            },
            saveAndContinue: function () {
                // const selectedEmployees = this.$store.getters.GET_SELECTEDEMPLOYEELIST;
                // if ( selectedEmployees.length > 0 ) {
                //     const url = Routing.generate("post_job_employee", { "id": this.job.id });
                //
                //     console.log(url);
                //     const payload = {
                //         employees: selectedEmployees
                //     };
                //     axios.post(url,payload)
                //          .then(response => {
                //             console.log("ADD_CALL response");
                //             console.log(response);
                             window.location.href = Routing.generate("job_index");
                        // })
                        //  .catch(e => {
                        //      console.log("HORROR!!!");
                        //
                        //  });
                // }
            }
        }
    }
</script>
