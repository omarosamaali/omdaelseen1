@extends($layout)

@section('content')
<h2 class="text-right mb-4 font-bold text-xl" style="display: flex; margin-top: 50px; margin-right: 50px; ">كيف نعمل</h2>

    <div style="display: flex; flex-direction: row-reverse; position: relative; z-index: 1;">
        <div class="container py-4 mx-auto max-w-4xl" style="position: relative; right: -50px; background: white; border-radius: 10px; padding: 20px;">
            <form action="{{ route('admin.works.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-4">
                    <!-- المحرر بالعربية -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">المحتوى بالعربية</label>
                        <div class="editor-wrapper">
                            <div class="toolbar">
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('bold', 'editor_ar')"><b>غامق</b></button>
                                    <button type="button" onclick="execCommandWithFocus('italic', 'editor_ar')"><i>مائل</i></button>
                                    <button type="button" onclick="execCommandWithFocus('underline', 'editor_ar')"><u>تحته خط</u></button>
                                </div>
                                <div class="toolbar-group">
                                    <select onchange="execCommandWithFocus('formatBlock', 'editor_ar', this.value)">
                                        <option value="p">فقرة عادية</option>
                                        <option value="h1">عنوان 1</option>
                                        <option value="h2">عنوان 2</option>
                                        <option value="h3">عنوان 3</option>
                                        <option value="pre">كود</option>
                                    </select>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('justifyRight', 'editor_ar')">محاذاة لليمين</button>
                                    <button type="button" onclick="execCommandWithFocus('justifyCenter', 'editor_ar')">توسيط</button>
                                    <button type="button" onclick="execCommandWithFocus('justifyLeft', 'editor_ar')">محاذاة لليسار</button>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('insertUnorderedList', 'editor_ar')">قائمة نقطية</button>
                                    <button type="button" onclick="execCommandWithFocus('insertOrderedList', 'editor_ar')">قائمة مرقمة</button>
                                </div>
                                <div class="toolbar-group">
                                    <input type="color" class="color-picker" oninput="setTextColor('editor_ar', this.value)">
                                    <select onchange="execCommandWithFocus('fontName', 'editor_ar', this.value)">
                                        <option value="Arial">أريال</option>
                                        <option value="Times New Roman">تايمز نيو رومان</option>
                                        <option value="Courier New">كوريير نيو</option>
                                        <option value="Tajawal">تاجوال</option>
                                    </select>
                                    <select onchange="execCommandWithFocus('fontSize', 'editor_ar', this.value)">
                                        <option value="1">صغير جدًا</option>
                                        <option value="2">صغير</option>
                                        <option value="3" selected>عادي</option>
                                        <option value="4">كبير</option>
                                        <option value="5">كبير جدًا</option>
                                        <option value="6">ضخم</option>
                                        <option value="7">ضخم جدًا</option>
                                    </select>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="triggerManualTranslation('editor_ar', 'ar', ['en', 'zh-CN'], [$('#editor_en')[0], $('#editor_ch')[0]])">ترجم يدويًا</button>
                                </div>
                            </div>
                            <div class="editor-container">
                                <div class="line-numbers" id="lineNumbers_ar"></div>
                                <div class="editor-content" id="editor_ar" contenteditable="true" data-lang="ar"></div>
                            </div>
                            <div class="status-bar">
                                <span id="charCount_ar">عدد الأحرف: 0</span>
                                <span id="wordCount_ar">عدد الكلمات: 0</span>
                            </div>
                        </div>
                        <input type="hidden" name="content_ar" id="content_ar">
                        @error('content_ar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- المحرر بالإنجليزية (الآن بالعربية) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">المحتوى بالإنجليزية</label>
                        <div class="editor-wrapper">
                            <div class="toolbar">
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('bold', 'editor_en')"><b>غامق</b></button>
                                    <button type="button" onclick="execCommandWithFocus('italic', 'editor_en')"><i>مائل</i></button>
                                    <button type="button" onclick="execCommandWithFocus('underline', 'editor_en')"><u>تحته خط</u></button>
                                </div>
                                <div class="toolbar-group">
                                    <select onchange="execCommandWithFocus('formatBlock', 'editor_en', this.value)">
                                        <option value="p">فقرة عادية</option>
                                        <option value="h1">عنوان 1</option>
                                        <option value="h2">عنوان 2</option>
                                        <option value="h3">عنوان 3</option>
                                        <option value="pre">كود</option>
                                    </select>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('justifyRight', 'editor_en')">محاذاة لليمين</button>
                                    <button type="button" onclick="execCommandWithFocus('justifyCenter', 'editor_en')">توسيط</button>
                                    <button type="button" onclick="execCommandWithFocus('justifyLeft', 'editor_en')">محاذاة لليسار</button>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('insertUnorderedList', 'editor_en')">قائمة نقطية</button>
                                    <button type="button" onclick="execCommandWithFocus('insertOrderedList', 'editor_en')">قائمة مرقمة</button>
                                </div>
                                <div class="toolbar-group">
                                    <input type="color" class="color-picker" oninput="setTextColor('editor_en', this.value)">
                                    <select onchange="execCommandWithFocus('fontName', 'editor_en', this.value)">
                                        <option value="Arial">أريال</option>
                                        <option value="Times New Roman">تايمز نيو رومان</option>
                                        <option value="Courier New">كوريير نيو</option>
                                        <option value="Tajawal">تاجوال</option>
                                    </select>
                                    <select onchange="execCommandWithFocus('fontSize', 'editor_en', this.value)">
                                        <option value="1">صغير جدًا</option>
                                        <option value="2">صغير</option>
                                        <option value="3" selected>عادي</option>
                                        <option value="4">كبير</option>
                                        <option value="5">كبير جدًا</option>
                                        <option value="6">ضخم</option>
                                        <option value="7">ضخم جدًا</option>
                                    </select>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="triggerManualTranslation('editor_en', 'en', ['ar', 'zh-CN'], [$('#editor_ar')[0], $('#editor_ch')[0]])">ترجم يدويًا</button>
                                </div>
                            </div>
                            <div class="editor-container">
                                <div class="line-numbers" id="lineNumbers_en"></div>
                                <div class="editor-content" id="editor_en" contenteditable="true" data-lang="en" style="direction: ltr; text-align: left;"></div>
                            </div>
                            <div class="status-bar">
                                <span id="charCount_en">عدد الأحرف: 0</span>
                                <span id="wordCount_en">عدد الكلمات: 0</span>
                            </div>
                        </div>
                        <input type="hidden" name="content_en" id="content_en">
                        @error('content_en')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- المحرر بالصينية (الآن بالعربية) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">المحتوى بالصينية</label>
                        <div class="editor-wrapper">
                            <div class="toolbar">
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('bold', 'editor_ch')"><b>غامق</b></button>
                                    <button type="button" onclick="execCommandWithFocus('italic', 'editor_ch')"><i>مائل</i></button>
                                    <button type="button" onclick="execCommandWithFocus('underline', 'editor_ch')"><u>تحته خط</u></button>
                                </div>
                                <div class="toolbar-group">
                                    <select onchange="execCommandWithFocus('formatBlock', 'editor_ch', this.value)">
                                        <option value="p">فقرة عادية</option>
                                        <option value="h1">عنوان 1</option>
                                        <option value="h2">عنوان 2</option>
                                        <option value="h3">عنوان 3</option>
                                        <option value="pre">كود</option>
                                    </select>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('justifyRight', 'editor_ch')">محاذاة لليمين</button>
                                    <button type="button" onclick="execCommandWithFocus('justifyCenter', 'editor_ch')">توسيط</button>
                                    <button type="button" onclick="execCommandWithFocus('justifyLeft', 'editor_ch')">محاذاة لليسار</button>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="execCommandWithFocus('insertUnorderedList', 'editor_ch')">قائمة نقطية</button>
                                    <button type="button" onclick="execCommandWithFocus('insertOrderedList', 'editor_ch')">قائمة مرقمة</button>
                                </div>
                                <div class="toolbar-group">
                                    <input type="color" class="color-picker" oninput="setTextColor('editor_ch', this.value)">
                                    <select onchange="execCommandWithFocus('fontName', 'editor_ch', this.value)">
                                        <option value="Arial">أريال</option>
                                        <option value="Times New Roman">تايمز نيو رومان</option>
                                        <option value="Courier New">كوريير نيو</option>
                                        <option value="Tajawal">تاجوال</option>
                                    </select>
                                    <select onchange="execCommandWithFocus('fontSize', 'editor_ch', this.value)">
                                        <option value="1">صغير جدًا</option>
                                        <option value="2">صغير</option>
                                        <option value="3" selected>عادي</option>
                                        <option value="4">كبير</option>
                                        <option value="5">كبير جدًا</option>
                                        <option value="6">ضخم</option>
                                        <option value="7">ضخم جدًا</option>
                                    </select>
                                </div>
                                <div class="toolbar-group">
                                    <button type="button" onclick="triggerManualTranslation('editor_ch', 'zh-CN', ['ar', 'en'], [$('#editor_ar')[0], $('#editor_en')[0]])">ترجم يدويًا</button>
                                </div>
                            </div>
                            <div class="editor-container">
                                <div class="line-numbers" id="lineNumbers_ch"></div>
                                <div class="editor-content" id="editor_ch" contenteditable="true" data-lang="zh-CN" style="direction: ltr; text-align: left;"></div>
                            </div>
                            <div class="status-bar">
                                <span id="charCount_ch">عدد الأحرف: 0</span>
                                <span id="wordCount_ch">عدد الكلمات: 0</span>
                            </div>
                        </div>
                        <input type="hidden" name="content_zh" id="content_zh">
                        @error('content_zh')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- الحالة -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الحالة</label>
                        <select name="status" style="direction: ltr;" class="input-field @error('status') border-red-500 @enderror">
                            <option>اختر</option>
                            <option value="نشط" {{ old('status') == 'نشط' ? 'selected' : '' }}>نشط</option>
                            <option value="غير نشط" {{ old('status') == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- الصورة -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">الصورة</label>
                        <input type="file" name="avatar" class="input-field @error('avatar') border-red-500 @enderror">
                        @error('avatar')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-dark px-4 py-2 mt-4 bg-black text-white rounded-md">إضافة</button>
            </form>
        </div>
    </div>

    <!-- أدوات تغيير حجم الصورة -->
    <div class="image-resize-controls" id="imageResizeControls">
        <span>العرض: </span>
        <input type="number" id="imgWidth" min="10">
        <span>الارتفاع: </span>
        <input type="number" id="imgHeight" min="10">
        <button type="button" id="applyResize">تطبيق</button>
        <button type="button" id="cancelResize">إلغاء</button>
        <button type="button" id="deleteImage" class="delete-btn">حذف الصورة</button>
    </div>

    <!-- نافذة تحديد حجم الصورة -->
    <div class="modal" id="imageSizeModal">
        <div class="modal-content">
            <h3>تحديد حجم الصورة</h3>
            <div>
                <label>العرض: </label>
                <input type="number" id="modalImgWidth" min="10" value="300">
            </div>
            <div>
                <label>الارتفاع: </label>
                <input type="number" id="modalImgHeight" min="10" value="200">
            </div>
            <button type="button" class="confirm-btn" id="confirmImageSize">تأكيد</button>
            <button type="button" class="cancel-btn" id="cancelImageSize">إلغاء</button>
        </div>
    </div>

    <!-- إضافة jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // متغيرات عالمية
        let selectedImage = null;
        let aspectRatio = 1;
        let currentImageFile = null;
        let currentEditorId = null;

        // دالة لتنفيذ الأوامر مع التركيز
        function execCommandWithFocus(command, editorId, value = null) {
            const editor = document.getElementById(editorId);
            editor.focus();
            document.execCommand(command, false, value);
            updateStats(editorId);
            updateHiddenInputs();
        }

        // ضبط لون النص
        function setTextColor(editorId, color) {
            const editor = document.getElementById(editorId);
            editor.focus();
            document.execCommand('foreColor', false, color);
            updateStats(editorId);
            updateHiddenInputs();
        }

        // دالة لتأخير الطلبات (debouncing)
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // دالة الترجمة
        function translateText(text, sourceLang, targetLangs, sourceEditor, targetEditors) {
            if (!text.trim()) {
                targetEditors.forEach(editor => $(editor).html(''));
                return;
            }

            $.ajax({
                url: '{{ route('translate') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    text: text,
                    source_lang: sourceLang,
                    target_langs: targetLangs
                },
                success: function(response) {
                    targetEditors.forEach((editor, index) => {
                        const translatedText = response[targetLangs[index]] || '';
                        // نسخ المحتوى الكامل من المحرر الأصلي
                        const sourceHTML = $(sourceEditor).html();
                        // تحديث النصوص فقط داخل العناصر النصية
                        $(editor).html(sourceHTML);
                        const textNodes = getTextNodes(editor);
                        textNodes.forEach(node => {
                            if (node.textContent.trim()) {
                                node.textContent = translatedText;
                            }
                        });
                    });
                    updateHiddenInputs();
                    ['editor_ar', 'editor_en', 'editor_ch'].forEach(updateStats);
                },
                error: function(xhr) {
                    console.error('Translation failed:', xhr.status, xhr.responseJSON);
                    alert('فشل في الترجمة: ' + (xhr.responseJSON?.error || 'خطأ غير معروف'));
                }
            });
        }

        // دالة لجمع العقد النصية
        function getTextNodes(element) {
            const nodes = [];
            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            let node;
            while ((node = walker.nextNode())) {
                nodes.push(node);
            }
            return nodes;
        }

        // دالة الترجمة اليدوية
        function triggerManualTranslation(sourceEditorId, sourceLang, targetLangs, targetEditors) {
            const sourceEditor = document.getElementById(sourceEditorId);
            const text = $(sourceEditor).text();
            translateText(text, sourceLang, targetLangs, sourceEditor, targetEditors);
        }

        // تحديث الحقول المخفية
        function updateHiddenInputs() {
            $('#content_ar').val($('#editor_ar').html());
            $('#content_en').val($('#editor_en').html());
            $('#content_zh').val($('#editor_ch').html());
        }

        // تحديث عداد الخطوط
        function updateLineNumbers(editorId) {
            const editor = document.getElementById(editorId);
            const lineNumbers = document.getElementById(`lineNumbers_${editorId.split('_')[1]}`);
            const text = editor.innerHTML;
            const lines = text.split(/<div>|<p>|<br>/).length || 1;

            lineNumbers.innerHTML = '';
            for (let i = 1; i <= lines; i++) {
                lineNumbers.innerHTML += i + '<br>';
            }
        }

        // تحديث إحصائيات النص
        function updateStats(editorId) {
            const editor = document.getElementById(editorId);
            const charCount = document.getElementById(`charCount_${editorId.split('_')[1]}`);
            const wordCount = document.getElementById(`wordCount_${editorId.split('_')[1]}`);
            const text = editor.innerText || '';

            charCount.textContent = `عدد الأحرف: ${text.length}`; // يمكن تعديل النص حسب اللغة
            const words = text.trim().split(/\s+/).filter(word => word !== '');
            wordCount.textContent = `عدد الكلمات: ${words.length}`;
        }

        // دالة لمعالجة رفع الصور
        function handleImageUpload(fileInputId, editorId) {
            const fileInput = document.getElementById(fileInputId);
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        currentImageFile = file;
                        currentEditorId = editorId;
                        $('#imageSizeModal').show();
                    }
                });
            }
        }

        // إعداد الأحداث لكل محرر
        ['ar', 'en', 'ch'].forEach(lang => {
            const editor = document.getElementById(`editor_${lang}`);
            const fileInput = document.getElementById(`fileInput_${lang}`);

            // إعداد رفع الصور
            handleImageUpload(`fileInput_${lang}`, `editor_${lang}`);

            // أحداث الإدخال
            $(editor).on('input', function() {
                updateLineNumbers(`editor_${lang}`);
                updateStats(`editor_${lang}`);
                updateHiddenInputs();

                const targetLangs = lang === 'ar' ? ['en', 'zh-CN'] :
                                   lang === 'en' ? ['ar', 'zh-CN'] :
                                   ['ar', 'en'];
                const targetEditors = lang === 'ar' ? [$('#editor_en')[0], $('#editor_ch')[0]] :
                                     lang === 'en' ? [$('#editor_ar')[0], $('#editor_ch')[0]] :
                                     [$('#editor_ar')[0], $('#editor_en')[0]];
                debouncedTranslate(this, lang === 'ar' ? 'ar' : lang === 'en' ? 'en' : 'zh-CN', targetLangs, targetEditors);
            });

            // دعم Tab
            editor.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    document.execCommand('insertHTML', false, '    ');
                }
            });

            // إضافة أحداث النقر على الصور
            editor.addEventListener('click', function(e) {
                if (e.target.tagName === 'IMG') {
                    selectImage(e.target);
                    e.stopPropagation();
                }
            });
        });

        // دالة لتحديد الصورة
        function selectImage(img) {
            if (selectedImage) {
                selectedImage.classList.remove('selected-image');
            }
            selectedImage = img;
            selectedImage.classList.add('selected-image');

            const controls = $('#imageResizeControls');
            controls.show();
            $('#imgWidth').val(img.width);
            $('#imgHeight').val(img.height);
            aspectRatio = img.width / img.height;

            const rect = img.getBoundingClientRect();
            controls.css({
                top: rect.bottom + window.scrollY + 10,
                left: rect.left + window.scrollX
            });
        }

        // إغلاق أدوات تغيير الحجم عند النقر خارج الصورة
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.image-resize-controls').length && !$(e.target).is('img')) {
                if (selectedImage) {
                    selectedImage.classList.remove('selected-image');
                    selectedImage = null;
                }
                $('#imageResizeControls').hide();
            }
        });

        // تطبيق تغيير حجم الصورة
        $('#applyResize').on('click', function() {
            if (selectedImage) {
                const width = parseInt($('#imgWidth').val());
                const height = parseInt($('#imgHeight').val());
                if (width > 0 && height > 0) {
                    selectedImage.width = width;
                    selectedImage.height = height;
                    $('#imageResizeControls').hide();
                    selectedImage.classList.remove('selected-image');
                    selectedImage = null;
                }
            }
        });

        // إلغاء تغيير الحجم
        $('#cancelResize').on('click', function() {
            $('#imageResizeControls').hide();
            if (selectedImage) {
                selectedImage.classList.remove('selected-image');
                selectedImage = null;
            }
        });

        // حذف الصورة
        $('#deleteImage').on('click', function() {
            if (selectedImage) {
                selectedImage.remove();
                $('#imageResizeControls').hide();
                selectedImage = null;
            }
        });

        // تأكيد حجم الصورة في النافذة المنبثقة
        $('#confirmImageSize').on('click', function() {
            const width = parseInt($('#modalImgWidth').val());
            const height = parseInt($('#modalImgHeight').val());
            if (currentImageFile && width > 0 && height > 0) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.width = width;
                    img.height = height;
                    img.className = 'image-preview';
                    const editor = document.getElementById(currentEditorId);
                    editor.appendChild(img);
                    $('#imageSizeModal').hide();
                    updateHiddenInputs();
                };
                reader.readAsDataURL(currentImageFile);
            }
        });

        // إلغاء النافذة المنبثقة
        $('#cancelImageSize').on('click', function() {
            $('#imageSizeModal').hide();
            currentImageFile = null;
            currentEditorId = null;
        });

        // مراقبة التغييرات في المحررات
        const debouncedTranslate = debounce(function(editor, sourceLang, targetLangs, targetEditors) {
            const text = $(editor).text();
            translateText(text, sourceLang, targetLangs, editor, targetEditors);
        }, 500);

        // تهيئة المحررات
        $(document).ready(function() {
            ['ar', 'en', 'ch'].forEach(lang => {
                updateLineNumbers(`editor_${lang}`);
                updateStats(`editor_${lang}`);
            });
        });
    </script>

    <!-- CSS -->
    <style>
        * {
            box-sizing: border-box;
        }

        .editor-wrapper {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .toolbar {
            padding: 10px;
            background-color: #f1f1f1;
            border-bottom: 1px solid #ddd;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .toolbar button {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .toolbar button:hover {
            background-color: #e9e9e9;
        }

        .toolbar select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .toolbar .color-picker {
            height: 30px;
            width: 30px;
            padding: 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .editor-container {
            display: flex;
            height: 300px;
        }

        .line-numbers {
            width: 40px;
            background-color: #f8f8f8;
            padding: 10px 5px;
            text-align: left;
            color: #777;
            font-size: 14px;
            line-height: 1.5;
            border-right: 1px solid #ddd;
            overflow-y: hidden;
            user-select: none;
        }

        .editor-content {
            flex-grow: 1;
            padding: 10px;
            overflow-y: auto;
            min-height: 300px;
            border: none;
            outline: none;
            resize: none;
            font-size: 16px;
            line-height: 1.5;
        }

        .status-bar {
            padding: 5px 10px;
            background-color: #f1f1f1;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
            display: flex;
            justify-content: space-between;
        }

        .file-input {
            display: none;
        }

        .image-preview {
            max-width: 100%;
            margin: 10px 0;
            cursor: pointer;
        }

        .toolbar-group {
            display: flex;
            gap: 5px;
            margin-left: 10px;
        }

        .selected-image {
            outline: 2px dashed #007bff;
        }

        .image-resize-controls {
            display: none;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            position: fixed;
            padding: 10px;
            border-radius: 5px;
            z-index: 100;
        }

        .image-resize-controls input {
            width: 60px;
            margin: 0 5px;
        }

        .image-resize-controls button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 5px;
        }

        .image-resize-controls .delete-btn {
            background-color: #dc3545;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 200;
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 300px;
            text-align: center;
        }

        .modal-content input {
            width: 80px;
            margin: 10px 5px;
            padding: 5px;
        }

        .modal-content button {
            margin: 10px 5px;
            padding: 8px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .modal-content .confirm-btn {
            background-color: #007bff;
            color: white;
        }

        .modal-content .cancel-btn {
            background-color: #6c757d;
            color: white;
        }
    </style>
@endsection