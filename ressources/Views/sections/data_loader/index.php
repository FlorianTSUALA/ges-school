<?php
    use Core\Routing\URL;
?>
<style>
    #mydiv:hover {
        background-color: #f5a663;

    }
</style>

<!-- 
    ******  VARIABLES *****
        
    --- $title 

-->

<div class="app-content content  ">
			<div class="content-wrapper">
				<div class="content-body">

                    <div class="row">
                        <div  class="col">

                            <a href='<?= URL::link('loader_eleve');?>' style="cursor:pointer; text-decoration: none;">
                                <div id="mydiv" class="card border-0 shadow bg-Orange  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-graduation-cap fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Chargement Eleves</strong></h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>

                        <div class="col">
                            <a href="<?= "#" ?>" style="cursor:pointer; text-decoration: none;">
                                <div  id="mydiv" class="card border-0 shadow  ">
                                    <div class="card-body kgs-bg-yellow">
                                        <div class="row align-items-end h3 kgs-green">
                                            <div class="col-12 text-center">
                                                <span class="fa fa-trophy fa-5x"></span>
                                            </div>

                                            <div class="col">
                                                <h1 align="center" class="text-uppercase pt-1"><strong>Chargement des Notes</strong></h1>
                                            </div>

                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 32px;"></th>
                                                        <th style="width: 7em;"></th>
                                                        <th style="width: 7em;">Test 1</th>
                                                        <th style="width: 10em;">Test 2 </th>
                                                        <th style="width: auto;">Test 3</th>
                                                        <th style="width: 10em;">Test 4
                                                        <th style="width: auto;">Test 5 </th>
                                                        <th style="width: auto;">Alternative 1</th>
                                                        <th style="width: 10em;">Probability 1</th>
                                                        <th style="width: auto;">Alternative 2</th>
                                                        <th style="width: 10em;">Probability 2</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr  class="shareEditor">
                                                    <input  type="hidden" value="1" />
                                                    <input  type="hidden" value="7" />
                                                    <input  type="hidden" value="0" />
                                                    <input  type="hidden" value="2" />
                                                    <td>
                                                    </td>
                                                    <td>Test</td>
                                                    <td>
                                                <input  type="hidden" value="True" /><input  type="hidden" value="1" />Test</td>
                                        <td><input class="form-control"  type="text" value="" /></td>
                                        <td>
                                            <div class="input-group">
                                                <input value="0" class="form-control" />
                                                <div class="input-group-append input-group-text">m3</div>
                                            </div>
                                        </td>
                                        <!-- Omitted -->
                                        </tr>            
                                    </tbody>
                                    </table>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                      
                    </div>

				</div>
			</div>
		</div>
