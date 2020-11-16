<template>
    <div>

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
                        v-print="'#print_'"
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
                    <v-btn
                        color="pink"
                        style="margin-bottom: 50px"
                        fab
                        dark
                        small
                        fixed
                        bottom
                        right
                        @click.stop="show_individual_report = !show_individual_report"
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon v-if="show_individual_report === true">fa-eye-slash</v-icon>
                        <v-icon v-if="show_individual_report === false">fa-eye</v-icon>
                    </v-btn>
                </template>
                <span v-if="show_individual_report === true">Hide individual report</span>
                <span v-if="show_individual_report === false">View individual report</span>
            </v-tooltip>
        </div>

        <div id="print_">
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
                            <td class="font-weight-bold text--black">Overall Report</td>
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
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th class="text-left">
                                <router-link to="/stocks-out">
                                    Items out of stock
                                </router-link>
                            </th>
                            <th class="text-left">
                                <router-link to="/stocks-in">
                                    Items in-stock
                                </router-link>
                            </th>
                            <th class="text-left">
                                Total items left
                            </th>
                            <th class="text-left">
                                Total Items Price
                            </th>
                            <th class="text-left">
                                Total Expenses
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><router-link to="/stocks-out"> {{items_out_of_stock}} </router-link></td>
                            <td><router-link to="/stocks-in"> {{items_instock}} </router-link></td>
                            <td>{{total_items_left}}</td>
                            <td>{{total_items_price}}</td>
                            <td>{{total_expenses}}</td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <v-divider class="m-0"></v-divider>
            </template>

            <template>

            </template>

            <template v-if="show_individual_report">

                <div>
                    <v-list-item  v-for="report in sales">
                        <v-list-item-content>
                            <v-list-item-title style="font-weight: bolder; font-size: 16px">
                                <v-row>
                                    <v-col cols="6">{{ report[0].date}}</v-col>
                                    <v-col cols="6">Sold By: {{report[0].user.name}}</v-col>
                                </v-row>
                            </v-list-item-title>

                            <v-list-item-subtitle class="ml-5" v-for="sale in report">
                                <v-row>
                                    <v-col cols="3">{{sale.item_name}}<span class="text-danger" v-if="sale.item == null">(deleted)</span></v-col>
                                    <v-col cols="3">Quantity: {{sale.quantity}}</v-col>
                                    <v-col cols="3">Price: {{sale.price}}</v-col>
                                    <v-col cols="3">Profit: {{sale.profit}}</v-col>
                                </v-row>
                                <v-divider class="m-0"></v-divider>
                            </v-list-item-subtitle>
                            <v-list-item-subtitle class="ml-5">
                                <v-row>
                                    <v-col cols="4"></v-col>
                                    <v-col cols="4" class="font-weight-bolder">Total: GH Cedis {{report[0].total_income}}</v-col>
                                    <v-col cols="4" class="font-weight-bolder">Total: GH Cedis {{report[0].total_profit}}</v-col>
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
        name: "OverallReport",
        data: ()=>({
            sales: [],
            total_income: 0,
            total_profit: 0,
            total_sales:0,
            show_individual_report: false,
            items_out_of_stock: 0,
            items_instock: 0,
            total_items_left: 0,
            total_items_price: 0,
            total_expenses: 0,
        }),
        methods: {
            fetchReport(){
                axios.get('report/overall').then((res)=>{
                    this.sales = res.data['sales']
                    this.total_income = res.data['total_income']
                    this.total_profit = res.data['total_profit']
                    this.total_sales = res.data['total_sales']

                    this.items_out_of_stock= res.data['items_out_of_stock']
                    this.items_instock= res.data['items_instock']
                    this.total_items_left= res.data['total_items_left']
                    this.total_items_price= res.data['total_items_price']
                    this.total_expenses= res.data['total_expenses']
                })
            }
        },
        created() {
            this.fetchReport()
        }
    }
</script>

<style scoped>

</style>
