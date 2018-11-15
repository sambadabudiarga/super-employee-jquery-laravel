<?php

function datatable($model, $request) {
    $data = [];

    // set initial value
    $data["draw"] = $request->get('draw');
    $data["recordsTotal"] = $model->count();
    $data["recordsFiltered"] = 0;
    $data["data"] = [];


    // get column names from query
    $columns = $model->getQuery()->columns;

    // // filter data
    $search_val = $request->get('search')['value'];
    if ($search_val != '') {
        $model = $model->where(function($query) use ($request, $columns, $search_val) {
            // get datatable parameter columns
            $dt_columns = $request->get('columns');
    
            foreach ($dt_columns as $dt_column) {
                if ($dt_column["searchable"]) {
                    $column_real_name = "";
                    foreach ($columns as $column) {
                        // get column name
                        $col_names = explode(' as ', $column);
                        $col_name = '';
                        if (count($col_names) > 1) {
                            $col_name = $col_names[1];
                        } else {
                            $col_name = $col_names[0];
                        }

                        if ($dt_column["data"] == $col_name) {
                            $column_real_name = $col_names[0];
                        }
                    }

                    if ($column_real_name != '') {
                        $query->orWhereRaw($column_real_name . " like ?", ["%$search_val%"]);
                    }
                }
            }
        });
    }

    $data["recordsFiltered"] = $model->count();

    // set data ordering
    $order_column_no = $request->get('order')[0]['column'];
    $order_column_dir = $request->get('order')[0]['dir'];
    $order_column_name = $request->get('columns')[$order_column_no]['data'];

    foreach ($columns as $column) {
        // get column name
        $col_names = explode(' as ', $column);
        $col_name = '';
        if (count($col_names) > 1) {
            $col_name = $col_names[1];
        } else {
            $col_name = $col_names[0];
        }

        if ($col_name == $order_column_name) {
            $order_column_name = $col_name;
            break;
        }

    }

    $model = $model->orderBy($order_column_name, $order_column_dir);

    // get data pagination
    $model = $model->getQuery()->skip($request->input('start'))
                ->take((int) $request->input('length') > 0 ? $request->input('length') : 10);

    $data["data"] = $model->get();

    return $data;
}