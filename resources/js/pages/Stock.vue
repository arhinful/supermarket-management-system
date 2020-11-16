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
                    v-print="'#print__'"
                    v-bind="attrs"
                    v-on="on"
                >
                    <v-icon>mdi-printer</v-icon>
                </v-btn>
            </template>
            <span>Print Info</span>
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

        <div id="print__">
            <v-card
                elevation="2"
                tile
                outline
            >
                <v-card-title>
                    Details of {{item.name}}
                </v-card-title>
                <v-col>

                    <v-row>
                        <v-col cols="3">
                            Purchase Price
                        </v-col>
                        <v-col cols="6">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="3">
                            {{item.purchase_price}}
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="3">
                            Selling Price
                        </v-col>
                        <v-col cols="6">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="3">
                            {{item.selling_price}}
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="3">
                            Store Box
                        </v-col>
                        <v-col cols="6">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="3">
                            {{item.store_box}}
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="3">
                            Quantity In Stock
                        </v-col>
                        <v-col cols="6">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="3">
                            {{item.quantity}}
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="3">
                            Number Of Sales
                        </v-col>
                        <v-col cols="6">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="3">
                            {{item.number_of_sales}}
                        </v-col>
                    </v-row>

                </v-col>
            </v-card>
            <v-divider></v-divider>

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
                                    <v-col cols="4">{{sale.item.name}}</v-col>
                                    <v-col cols="4">Price: {{sale.price}}</v-col>
                                    <v-col cols="4">Profit: {{sale.profit}}</v-col>
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
        name: "Stock",
        data: ()=>({
            item: {},
            sales: [],
            show_individual_report: false,
        }),
        created() {
            let id = this.$route.params.id
            axios.get('/item/get/'+id).then((res)=>{
                this.item = res.data['item']
                this.sales = res.data['sales']
            })
        },
    }
</script>

<style scoped>

</style>
