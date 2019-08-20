<!-- The Modal For Add Category -->
<div class="modal" id="modalEditCategory">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="CategoryName">Edit Category</label>
            <input class="form-control" type="text" name="CategoryName" id="CategoryName">
          </div>
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="CategoryBtnUpdate">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- The Modal Add Priceset-->
<div class="modal" id="addPriceSet">
  <div class="modal-dialog mw-100 w-75">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title pricesetTitle" >Price Set For:</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <form method="POST" >
          <div class="form-group">
            <label for="PriceSetType">Current Price Set:</label><br>
            <div class="row w-100 priceSetRow" id="contentPanel">
              <div class="col-sm-6 d-flex" style="background-color: red;">
              <div class="col-sm-4 d-flex justify-content-center">
                <label>Description</label>
              </div>
              <div class="col-sm-6 d-flex justify-content-start">
                <input class="form-control w-100" type="text" id="PriceSetType" value="">
              </div>
              <div class="col-sm-2 d-flex justify-content-start ">
                <button type="button" class="btn btn-xs btn-danger removeDescription">x</button>
              </div>
              </div>
              <div class="col-sm-6 d-flex">
              <div class="col-sm-4 d-flex justify-content-center">
                <label>Description</label>
              </div>
              <div class="col-sm-6 d-flex justify-content-start">
                <input class="form-control w-100" type="text" id="PriceSetType" value="">
              </div>
              <div class="col-sm-2 d-flex justify-content-start ">
                <button type="button" class="btn btn-xs btn-danger removeDescription">x</button>
              </div>
              </div>
              @if (isset($priceset)) 
              @foreach($pricesets as $priceset)
              <div class="col-sm-2 d-flex justify-content-center">
                <label>Description</label>
              </div>
              <div class="col-sm-3 d-flex justify-content-start">
                <input class="form-control w-100" type="text" id="PriceSetType" value="">
              </div>
              <div class="col-sm-1 d-flex justify-content-start ">
                <button type="button" class="btn btn-xs btn-danger removeDescription">x</button>
              </div>
              @endforeach
              @endif
            </div>
            <button type="button" id="asdf">ADD</button>
          </div>
        </form>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="testingBtn">Testing</button>
        <button type="button" class="btn btn-primary" id="PriceSetBtnUpdate">Update</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>