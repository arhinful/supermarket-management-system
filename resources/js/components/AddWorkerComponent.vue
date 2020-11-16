<template>
    <div>

        <v-snackbar
            v-model="snack"
            :timeout="3000"
            :color="snackColor"
        >
            {{ snackText }}

            <template v-slot:action="{ attrs }">
                <v-btn
                    v-bind="attrs"
                    text
                    @click="snack = false"
                >
                    Close
                </v-btn>
            </template>
        </v-snackbar>


        <v-dialog v-model="show_this" class="ml-5" max-width="500px">
            <v-card>
                <v-card-text>
                    <v-container>
                        <v-form>
                            <v-card-title class="blue text-white">Add New User or Administrator</v-card-title>
                            <v-row no-gutters class="black--text">

                                <v-col class="col-12">
                                    <v-text-field label="Name" v-model="name_"></v-text-field>
                                </v-col>

                                <v-col class="col-12">
                                    <v-text-field label="Username" v-model="username"></v-text-field>
                                </v-col>

                                <v-col class="col-12">
                                    <v-text-field label="Salary" v-model="salary"></v-text-field>
                                </v-col>

                                <v-col class="col-12">
                                    <v-text-field label="Password" v-model="password"></v-text-field>
                                </v-col>

                                <v-col class="col-12">
                                    <v-select
                                        v-model="role"
                                        :items="user_role"
                                        label="User Role"
                                    ></v-select>
                                </v-col>

                            </v-row>
                        </v-form>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click.stop="$destroy">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="save">Save</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        name: "AddWorkerComponent",
        data: ()=>({
            name_: '',
            user_role: ['Administrator', 'Worker'],
            username: '',
            salary: 0,
            password: '',
            role: 'Worker',
            show_this: true,
            snack: false,
            snackColor: '',
            snackText: '',
        }),
        methods: {
            save(){
                let data = {
                    name: this.name_,
                    username: this.username,
                    salary: this.salary,
                    role: this.role,
                    password: this.password,
                }
                if (this.name_ === ''|| this.username === ''|| this.salary === ''
                    || this.role === ''|| this.password === ''){
                    this.snack = true
                    this.snackColor = 'error'
                    this.snackText = 'all fields are required'
                    return
                }
                axios.post('worker/create', data).then((res)=>{
                    this.snack = true
                    this.snackColor = 'success'
                    this.snackText = res.data['mess']
                    this.$emit('close_add_user')
                })
            },
        },
        destroyed(){
            this.$emit('close_add_user')
        }
    }
</script>

<style scoped>

</style>
