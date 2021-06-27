<template>
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="example1_length">
                <label>
                    Show
                    <select v-model="filter.row" class="custom-select custom-select-sm form-control form-control-sm">
                        <option v-for="data_value in filter.table_row">{{ data_value }}</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 text-right">
            <div id="example1_filter" class="dataTables_filter">
                <label>Search:<input type="search" class="form-control form-control-sm" placeholder="Search" v-model="filter.search"></label>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['filter']
}
</script>
