<form action="" id="goalForm" method="POST">
    <div class="upload-form row">
        <div class="col-12">
            <h4 class="goal-header">Create Goal</h4>
        </div>
        <div class="form-group col-6">
            <input class="form-control form-input-details" id="goalId" type="hidden">
            <input class="form-control " id="session" type="hidden">
            <label for="goalTitle">Title *</label>
            <input class="form-control form-input-details goal-field" id="goalTitle" type="text" required>
            <div class="error-container"></div>
        </div>
        {{-- <div class="col-6">
            <div class="form-group">
                <label for="session">Session *</label>
                <select class="form-control goal-field coaching-custom-select" required id="session" name="session">
                    <option value="">--Select Session--</option>
                </select>
                <div class="error-container"></div>
            </div>
        </div> --}}
        <div class="form-group col-6">
            <label for="goalDescription">Description</label>
            <textarea class="form-control form-input-details goal-field"  id="goalDescription" ></textarea>
        </div>
        <div class="col-12">
            <h4>Timeline</h4>
        </div>
        <div class="form-group col-6">
            <label for="goalStartDate">Start Date</label>
            <input class="form-control form-input-details goal-start-date goal-field" required id="goalStartDate" name="goalStartDate" type="text" required>
            <div class="error-container"></div>
        </div>
        <div class="form-group col-6">
          <label for="goalEndDate">End Date</label>
          <input class="form-control form-input-details goal-end-date goal-field" required id="goalEndDate" name="goalEndDate" type="text" required>
          <div class="error-container"></div>
      </div>
    </div>
</form>