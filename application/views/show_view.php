
<div class="row">
    <div class="col-lg-12" style="padding:0px;">
        <div class="tab-content" >
            <div id="home" class="tab-pane fade in active">
                <div class="col-lg-12">
                    <form class="form-horizontal " autocomplete="off" id="purchase_form"  data-toggle="validator">
                        <fieldset>
                            <div class="col-lg-12 shadow" style="padding:20px 20px 0px 20px;">
                                <legend id ="iom_id" iom_id="<?php echo $data['id']; ?>"><i class="glyphicon glyphicon-send" aria-hidden="true"></i> IOM №<?php echo $data['id']; ?> </legend>
                                <div class="form-group col-lg-12">
                                    <h4 class="col-lg-6"><legend id="user_id" user_id="<?php echo $data['employee_id'] ?>"><span class="label label-default">Initiator:</span>  <?php echo $data['fullname']; ?> </legend></h4>
                                    <h4 class="col-lg-6"><legend id="department_id" department_id="<?php echo $data['department_id'] ?>"><span class="label label-default">Department:</span> <?php echo $data['department']; ?></legend></h4>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <div class="col-lg-6">
                                        <h4 class="col-lg-6"><span class="label label-default">Budgets:</span></h4>
                                        <table id="budgets"></table>

                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="col-lg-6"><span class="label label-default">Signers:</span></h4>
                                        <table id="signers"></table>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3 class="col-lg-4"><span class="label label-default"> Purchase name: </span></h3>
                                    <div class="col-lg-12">
                                        <!--<textarea id="purchase_text" rows="4" style="width:100%; max-width: 100%; " class="form-control" required disabled="true"></textarea>-->
                                        <div style="border: 1px solid #ccc; border-radius:4px; background: #F5F5F5; padding: 15px;"><?php echo $data['name'];?></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3 class="col-lg-6"><span class="label label-default"> Substantiation: </span></h3>
                                    <div class="col-lg-12">
                                        <!--<textarea name="summernote" id="summernote" cols="10" rows="10"></textarea>-->
                                        <div style="border: 1px solid #ccc; border-radius:4px; background: #F5F5F5; padding: 15px;"><?php echo $data['substantation'];?></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3 class="col-lg-4"><span class="label label-default"> Files: </span></h3>
                                    <div class="col-lg-12">
                                        <table id="files"></table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3 class="col-lg-4"><span class="label label-default"> Comments: </span></h3>
                                    <div class="col-lg-12">
                                        <div class='comments' ng-controller='CommentsCtrl'>
                                            <form>
                                                <fieldset>
                                                    <legend>
                                                        Your comment
                                                    </legend>
                                                    <div>
                                                        <label>
                                                            Comment:
                                                            <textarea ng-model='text'></textarea>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input class='button' ng-click='submit()' type='submit' value='Submit'>
                                                    </div>
                                                </fieldset>
                                            </form>
                                            <h3>
                                                {{comments.length}} Comments
                                            </h3>
                                            <ul>
                                                <li ng-repeat='comment in comments'>
                                                    <div class='comment approved'>
                                                        <h4>
                                                            {{comment.text}}
                                                        </h4>
                                                        <div>
                                                            {{comment.time_stamp}}
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/main/iomShow.js" type="text/javascript"></script>