<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>


<script>
    
var JSGRID_EDIT_ROW_DATA_KEY = "JSGridEditRow";
var JSGRID_ROW_DATA_KEY = "JSGridItem";

var clients = [
	{  "Name": "Otto Clay",  "Age": 25,  "Country": 1,  "Address": "Ap #897-1459 Quam Avenue"}, 
  {  "Name": "Connor Johnston",  "Age": 45,  "Country": 2,  "Address": "Ap #370-4647 Dis Av."}, 
  {  "Name": "Lacey Hess",  "Age": 29,  "Country": 4,  "Address": "37 Oak St, Melbourne"}
];

var countries = [
	{  Name: "",  Id: 0}, 
  {  Name: "United States",  Id: 1}, 
  {  Name: "Canada",  Id: 2}, 
  {  Name: "United Kingdom",  Id: 3}, 
  {  Name: "Australia",  Id: 4}
];

var $grid = $("#jsGrid");

$('#btnBatchSave').prop('disabled', true);

$("#content").on('click', '#btnBatchEdit', function() {
  $grid.jsGrid("fieldOption", 4, "visible", false);
  $('#btnBatchSave').prop('disabled', false);
  $('#btnBatchEdit').prop('disabled', true);

  var rows = $grid.jsGrid("option", "data");

  for (let row of rows)
    $grid.jsGrid("editItemBatch", row);
});

$("#content").on('click', '#btnBatchSave', function() {
  $grid.jsGrid("fieldOption", 4, "visible", true);
  $('#btnBatchSave').prop('disabled', true);
  $('#btnBatchEdit').prop('disabled', false);

  var rows = $grid.jsGrid("option", "data");
  
  for (let row of rows) {
    // 1. set current row to edit row.
    var $row = $grid.jsGrid("rowByItem", row);
    $grid.jsGrid("setEditingRow", $row);
    
    // 2. Get row with new values.
    //var editRow = $grid.jsGrid("_getEditRow"); // Unable to get new values here.

		// This returns the last row in the table (Lacey Hess), not the current row in the loop.
    // Not setting current edit item correctly?
		var editedItem = $grid.jsGrid("_getEditedItem"); 
    console.log("editedItem"); // Lacey Hess.
    console.log(editedItem);

    // 3. Compare with old row.
    // 4. if changed, add to array of changed rows.
    // 5. Save array of changed rows to DB via AJAX.
  }
});

$("#jsGrid").jsGrid({
  width: "100%",
  height: "400px",

  inserting: true,
  editing: true,
  sorting: true,
  paging: true,

  data: clients,

  fields: [
  	{ name: "Name", type: "text", width: 150, validate: "required"  }, 
    { name: "Age", type: "number", width: 50  }, 
    { name: "Address", type: "text", width: 200  }, 
    { name: "Country", type: "select", items: countries, valueField: "Id", textField: "Name"  }, 
    { type: "control" }
  ],
  _editRowBatch: function($row) {
    if (!this.editing)
      return;

    var item = $row.data(JSGRID_ROW_DATA_KEY);

    var args = this._callEventHandler(this.onItemEditing, {
      row: $row,
      item: item,
      itemIndex: this._itemIndex(item)
    });

    if (args.cancel)
      return;

    var $editRow = this._createEditRow(item);

    $row.hide();
    $editRow.insertBefore($row);
    $row.data(JSGRID_EDIT_ROW_DATA_KEY, $editRow);
  },
  editItemBatch: function(item) {
    var $row = this.rowByItem(item);
    if ($row.length)
      this._editRowBatch($row);
  },
  setEditingRow: function($row) {
    this._editingRow = $row;
    this.editing = true;
  },
  getEditingRow: function() {
    return this._editingRow;
  }
});

</script>