<template>
    <div>

        <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="pink"
                    fab
                    dark
                    small
                    fixed
                    bottom
                    right
                    v-print="'#print-area'"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon>mdi-printer</v-icon>
                </v-btn>
            </template>
            <span>Print report</span>
        </v-tooltip>

        <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
                <router-link to="/overall-report">
                    <v-btn
                        style="margin-bottom: 50px"
                        fab
                        dark
                        small
                        fixed
                        bottom
                        right
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon>mdi-arrow-up-bold-box-outline</v-icon>
                    </v-btn>
                </router-link>
            </template>
            <span>Load overall report</span>
        </v-tooltip>

        <v-container>
            <v-row>
                <v-col cols="6">
                    <v-dialog
                        ref="dialog"
                        v-model="modal"
                        :return-value.sync="date"
                        width="290px"
                        persistent
                    >
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field
                                v-model="date"
                                label="Picker in dialog"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker
                            v-model="date"
                            scrollable
                            range
                        >
                            <v-spacer></v-spacer>
                            <v-btn
                                text
                                color="primary"
                                @click="modal = false"
                            >
                                Cancel
                            </v-btn>
                            <v-btn
                                text
                                color="primary"

                                @click="$refs.dialog.save(date)"
                            >
                                OK
                            </v-btn>
                        </v-date-picker>
                    </v-dialog>
                </v-col>
                <v-col cols="6">
                   <span style="font-weight: bolder; font-size: 16px"> Selected Date: {{selected_date}}</span>
                </v-col>
            </v-row>
        </v-container>

        <v-divider class="m-0"></v-divider>
        <div id="print-area">
            <template>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th class="text-left">
                                Date
                            </th>
                            <th class="text-left">
                                Total Sales
                            </th>
                            <th class="text-left">
                                Total Income
                            </th>
                            <th class="text-left">
                                Total Profit
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="font-weight-bold text--black">{{selected_date}}</td>
                            <td>{{total_sales}}</td>
                            <td>{{total_income}}</td>
                            <td>{{total_profit}}</td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <v-divider class="m-0"></v-divider>
            </template>

            <template>

                <div>
                    <v-list-item  v-for="report in sales">
                        <v-list-item-content>
                            <v-list-item-title style="font-weight: bolder; font-size: 16px">
                                <v-row>
                                    <v-col cols="3">{{ report[0].date}}</v-col>
                                    <v-col cols="9">Sold By: {{report[0].user.name}}</v-col>
                                </v-row>
                            </v-list-item-title>

                            <v-list-item-subtitle class="ml-5" v-for="sale in report">
                                <v-row>
                                    <v-col cols="3">{{sale.item_name}}<span class="text-danger" v-if="sale.item == null">(deleted)</span> </v-col>
                                    <v-col cols="3">Quantity: {{sale.quantity}}</v-col>
                                    <v-col cols="3">Price: {{sale.price}}</v-col>
                                    <v-col cols="3">Profit: {{sale.profit}}</v-col>
                                </v-row>
                                <v-divider class="m-0"></v-divider>
                            </v-list-item-subtitle>
                            <v-list-item-subtitle class="ml-5">
                                <v-row>
                                    <v-col cols="3">Total: GH Cedis</v-col>
                                    <v-col cols="3"></v-col>
                                    <v-col cols="3" class="font-weight-bolder">{{report[0].total_income}}</v-col>
                                    <v-col cols="3" class="font-weight-bolder">{{report[0].total_profit}}</v-col>
                                </v-row>
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </div>

            </template>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Report",
        data: ()=>({
            date: [new Date().toISOString().substr(0, 10), new Date().toISOString().substr(0, 10)],
            modal: false,
            selected_date: '',
            sales: [],
            total_income: 0,
            total_profit: 0,
            total_sales:0,
            date_type: '',
        }),
        methods: {
            fetchReport(start, end=null){
                // fetch single day
                if (end === null || start === end){
                    this.date_type = 'single'
                    let data = {date: start}
                    axios.post('report/get-single-day', data).then((res)=>{
                        this.selected_date = start
                        this.sales = res.data['sales']
                        this.total_sales = res.data['total_sales']
                        this.total_income = res.data['total_income']
                        this.total_profit = res.data['total_profit']
                    })
                }
                // fetch within range range
                else {
                    this.date_type = 'range'
                    let data = {start: start, end: end}
                    axios.post('report/get-range', data).then((res)=>{
                        this.selected_date = start + ' to ' + end
                        this.sales = res.data['sales']
                        this.total_income = res.data['total_income']
                        this.total_profit = res.data['total_profit']
                        this.total_sales = res.data['total_sales']
                    })
                }
            }
        },
        watch: {
            date: {
                    handler (newDate, oldDate){
                    this.fetchReport(newDate[0], newDate[1])
                },
                deep: true
            }
        },
        created() {

            this.fetchReport(this.date[0])
        }
    }
</script>

<style scoped>

</style>
