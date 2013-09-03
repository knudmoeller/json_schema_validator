<?php include 'header.php'; ?>
          <p class="lead">
            Validate a JSON file 'semantically'<sup><a href="#syntactically">*</a></sup> against a <a href="http://json-schema.org">JSON Schema</a>, v4.
          </p>
          <p>Here is how to use the validator:</p>
          <ul>
            <li>specify the URI of the JSON schema below (you can also validate your own schema by validating against <a href="http://json-schema.org/schema">http://json-schema.org/schema</a>)</li>
            <li>specify your JSON data in one of three ways:
              <ul>
                <li><strong>upload</strong> the JSON file to validate</li>
                <li>enter in the <strong>URL</strong> of the JSON file online</li>
                <li>input the JSON directly into the <strong>text</strong> area</li>
              </ul></li>
            <li>click the 'validate' button</li>
          </ul>
        	<div id="upload-box">
        		<form class="form-horizontal" enctype="multipart/form-data" action="validator.php" method="POST">
        		  <fieldset>
        		    <legend>Schema Validation</legend>
                <div class="control-group">
        		      <label class="control-label" for="schema_uri">Schema URI</label>
        		      <div class="controls">
        		        <input name="schema_uri" class="url_field" type="text" placeholder="http://example.com/schema/uri…">
        		      </div>
        		    </div>
        		  	<ul class="nav nav-tabs" id="data_tabs">
                  <li class="active"><a href="#data_upload" data-toggle="tab">Upload</a></li>
                  <li><a href="#data_url" data-toggle="tab">URL</a></li>
                  <li><a href="#data_text" data-toggle="tab">Text Input</a></li>
                </ul>
                <div id="input_checkboxes">
                  <input type="radio" name="input_radio" value="data_upload" checked/>
                  <input type="radio" name="input_radio" value="data_url"/>
                  <input type="radio" name="input_radio" value="data_text"/>
                </div>
                <div class="tab-content">
                  <div class="tab-pane active" id="data_upload">
                    <div class="control-group">
                      <!-- <label class="control-label" for="json_file">JSON File</label> -->
        						  <div class="controls">
        						    <input id="json_file" name="uploadedfile" type="file" />
                		  	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
        						  </div>
        						</div>
                  </div>
                  <div class="tab-pane" id="data_url">
                    <div class="control-group">
                      <!-- <label class="control-label" for="data_uri">Data URI</label> -->
            		      <div class="controls">
            		        <input name="data_url" class="url_field" type="text" placeholder="http://example.com/data/uri…">
            		      </div>
            		    </div>
                  </div>
                  <div class="tab-pane" id="data_text">
                    <div class="controls">
                      <textarea name="data_text" class="form-control json_input" rows="10"  placeholder='{ "property": "value" }'></textarea>
                    </div>
                  </div>
                </div>
                
			          <div class="form-actions">  
                  <button type="submit" class="btn btn-primary">Validate</button>  
                </div>  
  						</fieldset>
        		</form>
        	</div>
        	
        	<div id="syntactically">
        	  <p>
              <small><sup>*</sup>If you are looking for a tool to check your JSON syntactically, there are many 
                tools out there that can help you. E.g., you could check <a href="http://jsonlint.com">JSONLint</a> or 
              <a href="http://json.parser.online.fr">JSON Parser Online</a>.</small>
            </p>
        	</div>
        	
<?php include 'footer.php'; ?>       	
