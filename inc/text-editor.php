<!-- parameters: 
    $updatePath, $postContent, $postID, $postStateID, $postImg, 
    $states, $postcategories, $categories  
-->
<form id="text-editor" action=<?=$updatePath?> method="post" enctype="multipart/form-data">
    <div id="text-editor-header" class="d-flex justify-content-center">
        <div >
            <span class="hidden-button btn btn border border-secondary" id="open-hidden-button">
                <i class="fa-solid fa-bars"></i>
            </span>
        </div>
        <div class="options" id="options-section">
            <span class="hidden-button btn btn border border-secondary" id="close-hidden-button">
                <i class="fa-solid fa-bars"></i>
            </span>
            <!-- Text Format -->
            <span id="bold" class="option-button btn format dynamic-button label-button" data-placeholder="bold">
                <i class="fa-solid fa-bold"></i>
            </span>
            <span id="italic" class="option-button btn format dynamic-button label-button" data-placeholder="italic">
                <i class="fa-solid fa-italic"></i>
            </span>
            <span id="underline" class="option-button btn format dynamic-button label-button" data-placeholder="underline">
                <i class="fa-solid fa-underline"></i>
            </span>
            <!-- <span id="strikethrough" class="option-button btn format dynamic-button">
                <i class="fa-solid fa-strikethrough"></i>
            </span> -->
            <span id="superscript" class="option-button btn script dynamic-button label-button" data-placeholder="superscript">
                <i class="fa-solid fa-superscript"></i>
            </span>
            <span id="subscript" class="option-button btn script dynamic-button label-button" data-placeholder="subscript">
                <i class="fa-solid fa-subscript"></i>
            </span>
            <!-- List -->
            <span id="insertOrderedList" class="option-button btn order-button label-button" data-placeholder="order list">
                <div class="fa-solid fa-list-ol"></div>
            </span>
            <span id="insertUnorderedList" class="option-button btn order-button label-button" data-placeholder="unorder list">
                <i class="fa-solid fa-list"></i>
            </span>
            <!-- Undo/Redo -->
            <span id="undo" class="option-button btn label-button" data-placeholder="undo">
                <i class="fa-solid fa-rotate-left"></i>
            </span>
            <span id="redo" class="option-button btn label-button" data-placeholder="redo">
                <i class="fa-solid fa-rotate-right"></i>
            </span>
            <!-- Image -->
            <div id="image-upload">
                <input type="file" accept="image/*" id="image-upload-input" hidden>
                <span id="image-upload-button" class="label-button" data-placeholder="upload image">
                    <i class="fa-regular fa-images"></i>
                </span>
            </div>
            <!-- Link -->
            <span id="createLink" class="adv-option-button btn label-button" data-placeholder="create link">
                <i class="fa fa-link"></i>
            </span>
            <span id="unlink" class="option-button btn label-button" data-placeholder="unlink">
                <i class="fa fa-unlink"></i>
            </span>
            <!-- Alignment -->
            <span id="justifyLeft" class="option-button btn align label-button" data-placeholder="justify left">
                <i class="fa-solid fa-align-left"></i>
            </span>
            <span id="justifyCenter" class="option-button btn align label-button" data-placeholder="justify center">
                <i class="fa-solid fa-align-center"></i>
            </span>
            <span id="justifyRight" class="option-button btn align label-button" data-placeholder="justify right">
                <i class="fa-solid fa-align-right"></i>
            </span>
            <span id="justifyFull" class="option-button btn align label-button" data-placeholder="justify full">
                <i class="fa-solid fa-align-justify"></i>
            </span>
            <!-- <span id="indent" class="option-button btn spacing label-button" data-placeholder="indent">
                <i class="fa-solid fa-indent"></i>
            </span> -->
            <!-- <span id="outdent" class="option-button btn spacing label-button" data-placeholder="outdent">
                <i class="fa-solid fa-outdent"></i>
            </span> -->
            <span id="insertHorizontalRule" class="option-button btn label-button" data-placeholder="horizonal rule">
                <i class="fa-solid fa-minus"></i>
            </span>
            <!-- Headings -->
            <select id="formatBlock" class="adv-option-button btn border border-secondary select-button">
                <option value="H1">H1</option>
                <option value="H2">H2</option>
                <option value="H3">H3</option>
                <option value="H4">H4</option>
                <option value="H5">H5</option>
                <option value="H6">H6</option>
            </select>
            <!-- Font -->
            <select id="fontName" class="adv-option-button btn border border-secondary select-button"></select>
            <select id="fontSize" class="adv-option-button btn border border-secondary select-button"></select>
            <!-- Color -->
            <div class="input-wrapper">
                <input type="color" id="foreColor" class="adv-option-button btn" />
                <label for="foreColor">Font Color</label>
            </div>
            <div class="input-wrapper">
                <input type="color" id="backColor" class="adv-option-button btn" />
                <label for="backColor">Highlight Color</label>
            </div>
        </div>
    </div>
    <div class="container" id="text-editor-body">
        <!-- content -->
        <div id="text-input">
            <h1 class="title line" contenteditable="true"></h1>
            <div class="line" contenteditable="true" data-placeholder="Enter text here"></div>
        </div>
        <div id="text-input-hiden" hidden>
            <?=$postContent?>
        </div>
        <input name="postID" type="text" value=<?=$postID ?? 0?> hidden />
    </div>
    <div class="buttons-form">
        <a href="../index.php" class="btn btn-light border-secondary-subtle">Home</a>
        <span id="next-button" class="btn btn-primary toggle-button">Next</span>
    </div>
    <!-- modal -->
    <div class="modal modal-overlay" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body rounded d-flex" id="text-editor-modal">
                    <div class="modal-post-custom">
                        <!-- states dropdown -->
                        <div class="states d-flex">
                            <div class="input-group-prepend">
                                <span class="input-group-text btn-secondary" id="inputGroup-sizing-default">State</span>
                            </div>
                            <select class="form-select w-auto mx-2" aria-label="Default select example" 
                                name="state" id="state-selector">
                                <?php foreach($states as $state): ?>
                                    <option value=<?=$state->id?> <?=$postStateID==$state->id ? 'selected': ''?>><?=$state->stateName?></option>        
                                <?php endforeach; ?>
                            </select>
                        </div><hr>

                        <!-- post image -->
                        <div class="post-img-conatiner">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Image</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="input-post-image" accept="image/*">
                                    <label class="custom-file-label" for="input-post-image">Choose a post image</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- categories -->
                        <div class="category-selector">
                            <div>
                                <category-checkbox categories=<?=json_encode($postcategories)?>></category-checkbox>   
                            </div>
                            <div id="category-checkbox-dropdown" class="bg-light bg-gradient py-2 px-3 d-none z-2">
                                <?php foreach($categories as $category):?>
                                    <div class="form-check pe-3">
                                        <input class="form-check-input category-check-input" type="checkbox" name="category" 
                                            id=<?=$category->category?> value=<?=$category->category?> 
                                            <?= in_array($category->category, $postcategories)?'checked':'' ?>>
                                        <label class="form-check-label" for=<?=$category->category?>>
                                            <?=$category->category?>
                                        </label>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div><hr>
                        <!-- button -->
                        <div class="d-flex justify-content-end">
                            <span class="btn btn-secondary mx-2 toggle-button">Cancel</span>
                            <!-- submit -->
                            <input type="submit" class="btn btn-primary" id="text-editor-submit"/>
                        </div>
                    </div>
                    <div class="modal-post-image">
                        <img width="350px" class="img-thumbnail" id="post-thumbnail-image" src=<?=$postImg?>>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <confirm-modal-form> -->
</form>