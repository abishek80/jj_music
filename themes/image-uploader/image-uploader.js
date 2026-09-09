/*! Image Uploader - v1.0.0 - 15/07/2019
 * Copyright (c) 2019 Christian Bayer; Licensed MIT */

(function ($) {

    $.fn.beforeImageUploader = function (options) {
        // Default settings
        let defaults = {
            preloaded: [],
            imagesInputName: 'before_images',
            preloadedInputName: 'preloaded',
            label: 'Drag & Drop files here or click to browse'
        };
    
        // Get instance
        let plugin = this;
    
        // Set empty settings
        plugin.settings = {};
    
        // Plugin constructor
        plugin.init = function () {
            plugin.settings = $.extend(plugin.settings, defaults, options);
    
            // Initialize for each element
            plugin.each(function (i, wrapper) {
                let $container = createContainer();
                $(wrapper).append($container);
    
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));
    
                if (plugin.settings.preloaded.length) {
                    $container.addClass('has-files');
                    let $uploadedContainer = $container.find('.uploaded');
                    for (let i = 0; i < plugin.settings.preloaded.length; i++) {
                        $uploadedContainer.append(createImg(plugin.settings.preloaded[i].src, plugin.settings.preloaded[i].id, true));
                    }
                }
            });
        };
    
        let dataTransfer = new DataTransfer();
    
        let createContainer = function () {
            let $container = $('<div>', { class: 'image-uploader' }),
                $input = $('<input>', {
                    type: 'file',
                    id: plugin.settings.imagesInputName + '-' + random(),
                    name: plugin.settings.imagesInputName + '[]',
                    multiple: ''
                }).appendTo($container),
                $uploadedContainer = $('<div>', { class: 'uploaded' }).appendTo($container),
                $textContainer = $('<div>', { class: 'upload-text' }).appendTo($container),
                $i = $('<i>', { class: 'bx bx-cloud-upload' }).appendTo($textContainer),
                $span = $('<span>', { text: plugin.settings.label }).appendTo($textContainer);
    
            $container.on('click', function (e) {
                prevent(e);
                $input.trigger('click');
            });
    
            $input.on("click", function (e) {
                e.stopPropagation();
            });
    
            $input.on('change', fileSelectHandler.bind($container));
    
            return $container;
        };
    
        let prevent = function (e) {
            e.preventDefault();
            e.stopPropagation();
        };
    
        let createImg = function (src, id, file_ext = null) {
            let $container = $('<div>', { class: 'uploaded-image' });
            let imgSrc = src;
    
            if (file_ext) {
                const fileIcons = {
                    pdf: '/static/images/pdf.png',
                    ppt: '/static/images/ppt.png',
                    csv: '/static/images/csv.png',
                    xlsx: '/static/images/xlsx.jpg',
                    xls: '/static/images/xlsx.jpg',
                    doc: '/static/images/doc.jpg',
                    docx: '/static/images/doc.jpg',
                    txt: '/static/images/doc.jpg'
                };
                imgSrc = fileIcons[file_ext] || src;
            }
    
            $('<img>', { src: imgSrc }).appendTo($container);
    
            let $button = $('<button>', { class: 'delete-image' }).appendTo($container);
            $('<i>', { class: 'bx bx-x' }).appendTo($button);
    
            if (plugin.settings.preloaded.length) {
                $container.attr('data-preloaded', true);
                $('<input>', {
                    type: 'hidden',
                    name: plugin.settings.preloadedInputName + '[]',
                    value: id
                }).appendTo($container);
            } else {
                $container.attr('data-index', id);
            }
    
            $button.on("click", function (e) {
                prevent(e);
    
                if ($container.data('index') !== undefined) {
                    let index = parseInt($container.data('index'));
                    dataTransfer.items.remove(index);
                    updateIndexes($container, index);
                }
    
                $container.remove();
                if (!$container.closest('.image-uploader').find('.uploaded .uploaded-image').length) {
                    $container.closest('.image-uploader').removeClass('has-files');
                }
            });
    
            return $container;
        };
    
        let updateIndexes = function ($container, removedIndex) {
            let $uploadedContainer = $container.closest('.uploaded');
            $uploadedContainer.find('.uploaded-image[data-index]').each(function () {
                let currentIndex = parseInt($(this).data('index'));
                if (currentIndex > removedIndex) {
                    $(this).attr('data-index', currentIndex - 1);
                }
            });
        };
    
        let fileDragHover = function (e) {
            prevent(e);
            if (e.type === "dragover") {
                $(this).addClass('drag-over');
            } else {
                $(this).removeClass('drag-over');
            }
        };
    
        let fileSelectHandler = function (e) {
            prevent(e);
            let $container = $(this);
            $container.removeClass('drag-over');
    
            let files = e.target.files || e.originalEvent.dataTransfer.files;
            setPreview($container, files);
        };
    
        let setPreview = function ($container, files) {
            $container.addClass('has-files');
            let $uploadedContainer = $container.find('.uploaded'),
                $input = $container.find('input[type="file"]');
    
            $(files).each(function (i, file) {
                let fileExt = file.name.split('.').pop().toLowerCase();
                dataTransfer.items.add(file);
                $uploadedContainer.append(createImg(URL.createObjectURL(file), dataTransfer.items.length - 1, fileExt));
            });
    
            $input.prop('files', dataTransfer.files);
        };
    
        let random = function () {
            return Date.now() + Math.floor((Math.random() * 100) + 1);
        };
    
        this.init();
        return this;
    };

    $.fn.afterImageUploader = function (options) {
        // Default settings
        let defaults = {
            preloaded: [],
            imagesInputName: 'after_images',
            preloadedInputName: 'preloaded',
            label: 'Drag & Drop files here or click to browse'
        };
    
        // Get instance
        let plugin = this;
    
        // Set empty settings
        plugin.settings = {};
    
        // Plugin constructor
        plugin.init = function () {
            plugin.settings = $.extend(plugin.settings, defaults, options);
    
            // Initialize for each element
            plugin.each(function (i, wrapper) {
                let $container = createContainer();
                $(wrapper).append($container);
    
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));
    
                if (plugin.settings.preloaded.length) {
                    $container.addClass('has-files');
                    let $uploadedContainer = $container.find('.uploaded');
                    for (let i = 0; i < plugin.settings.preloaded.length; i++) {
                        $uploadedContainer.append(createImg(plugin.settings.preloaded[i].src, plugin.settings.preloaded[i].id, true));
                    }
                }
            });
        };
    
        let dataTransfer = new DataTransfer();
    
        let createContainer = function () {
            let $container = $('<div>', { class: 'image-uploader' }),
                $input = $('<input>', {
                    type: 'file',
                    id: plugin.settings.imagesInputName + '-' + random(),
                    name: plugin.settings.imagesInputName + '[]',
                    multiple: ''
                }).appendTo($container),
                $uploadedContainer = $('<div>', { class: 'uploaded' }).appendTo($container),
                $textContainer = $('<div>', { class: 'upload-text' }).appendTo($container),
                $i = $('<i>', { class: 'bx bx-cloud-upload' }).appendTo($textContainer),
                $span = $('<span>', { text: plugin.settings.label }).appendTo($textContainer);
    
            $container.on('click', function (e) {
                prevent(e);
                $input.trigger('click');
            });
    
            $input.on("click", function (e) {
                e.stopPropagation();
            });
    
            $input.on('change', fileSelectHandler.bind($container));
    
            return $container;
        };
    
        let prevent = function (e) {
            e.preventDefault();
            e.stopPropagation();
        };
    
        let createImg = function (src, id, file_ext = null) {
            let $container = $('<div>', { class: 'uploaded-image' });
            let imgSrc = src;
    
            if (file_ext) {
                const fileIcons = {
                    pdf: '/static/images/pdf.png',
                    ppt: '/static/images/ppt.png',
                    csv: '/static/images/csv.png',
                    xlsx: '/static/images/xlsx.jpg',
                    xls: '/static/images/xlsx.jpg',
                    doc: '/static/images/doc.jpg',
                    docx: '/static/images/doc.jpg',
                    txt: '/static/images/doc.jpg'
                };
                imgSrc = fileIcons[file_ext] || src;
            }
    
            $('<img>', { src: imgSrc }).appendTo($container);
    
            let $button = $('<button>', { class: 'delete-image' }).appendTo($container);
            $('<i>', { class: 'bx bx-x' }).appendTo($button);
    
            if (plugin.settings.preloaded.length) {
                $container.attr('data-preloaded', true);
                $('<input>', {
                    type: 'hidden',
                    name: plugin.settings.preloadedInputName + '[]',
                    value: id
                }).appendTo($container);
            } else {
                $container.attr('data-index', id);
            }
    
            $button.on("click", function (e) {
                prevent(e);
    
                if ($container.data('index') !== undefined) {
                    let index = parseInt($container.data('index'));
                    dataTransfer.items.remove(index);
                    updateIndexes($container, index);
                }
    
                $container.remove();
                if (!$container.closest('.image-uploader').find('.uploaded .uploaded-image').length) {
                    $container.closest('.image-uploader').removeClass('has-files');
                }
            });
    
            return $container;
        };
    
        let updateIndexes = function ($container, removedIndex) {
            let $uploadedContainer = $container.closest('.uploaded');
            $uploadedContainer.find('.uploaded-image[data-index]').each(function () {
                let currentIndex = parseInt($(this).data('index'));
                if (currentIndex > removedIndex) {
                    $(this).attr('data-index', currentIndex - 1);
                }
            });
        };
    
        let fileDragHover = function (e) {
            prevent(e);
            if (e.type === "dragover") {
                $(this).addClass('drag-over');
            } else {
                $(this).removeClass('drag-over');
            }
        };
    
        let fileSelectHandler = function (e) {
            prevent(e);
            let $container = $(this);
            $container.removeClass('drag-over');
    
            let files = e.target.files || e.originalEvent.dataTransfer.files;
            setPreview($container, files);
        };
    
        let setPreview = function ($container, files) {
            $container.addClass('has-files');
            let $uploadedContainer = $container.find('.uploaded'),
                $input = $container.find('input[type="file"]');
    
            $(files).each(function (i, file) {
                let fileExt = file.name.split('.').pop().toLowerCase();
                dataTransfer.items.add(file);
                $uploadedContainer.append(createImg(URL.createObjectURL(file), dataTransfer.items.length - 1, fileExt));
            });
    
            $input.prop('files', dataTransfer.files);
        };
    
        let random = function () {
            return Date.now() + Math.floor((Math.random() * 100) + 1);
        };
    
        this.init();
        return this;
    };

    $.fn.jobReportUploader = function (options) {
        // Default settings
        let defaults = {
            preloaded: [],
            imagesInputName: 'job_report_letters',
            preloadedInputName: 'preloaded',
            label: 'Drag & Drop files here or click to browse'
        };
    
        // Get instance
        let plugin = this;
    
        // Set empty settings
        plugin.settings = {};
    
        // Plugin constructor
        plugin.init = function () {
            plugin.settings = $.extend(plugin.settings, defaults, options);
    
            // Initialize for each element
            plugin.each(function (i, wrapper) {
                let $container = createContainer();
                $(wrapper).append($container);
    
                $container.on("dragover", fileDragHover.bind($container));
                $container.on("dragleave", fileDragHover.bind($container));
                $container.on("drop", fileSelectHandler.bind($container));
    
                if (plugin.settings.preloaded.length) {
                    $container.addClass('has-files');
                    let $uploadedContainer = $container.find('.uploaded');
                    for (let i = 0; i < plugin.settings.preloaded.length; i++) {
                        $uploadedContainer.append(createImg(plugin.settings.preloaded[i].src, plugin.settings.preloaded[i].id, true));
                    }
                }
            });
        };
    
        let dataTransfer = new DataTransfer();
    
        let createContainer = function () {
            let $container = $('<div>', { class: 'image-uploader' }),
                $input = $('<input>', {
                    type: 'file',
                    id: plugin.settings.imagesInputName + '-' + random(),
                    name: plugin.settings.imagesInputName + '[]',
                    multiple: ''
                }).appendTo($container),
                $uploadedContainer = $('<div>', { class: 'uploaded' }).appendTo($container),
                $textContainer = $('<div>', { class: 'upload-text' }).appendTo($container),
                $i = $('<i>', { class: 'bx bx-cloud-upload' }).appendTo($textContainer),
                $span = $('<span>', { text: plugin.settings.label }).appendTo($textContainer);
    
            $container.on('click', function (e) {
                prevent(e);
                $input.trigger('click');
            });
    
            $input.on("click", function (e) {
                e.stopPropagation();
            });
    
            $input.on('change', fileSelectHandler.bind($container));
    
            return $container;
        };
    
        let prevent = function (e) {
            e.preventDefault();
            e.stopPropagation();
        };
    
        let createImg = function (src, id, file_ext = null) {
            let $container = $('<div>', { class: 'uploaded-image' });
            let imgSrc = src;
    
            if (file_ext) {
                const fileIcons = {
                    pdf: '/static/images/pdf.png',
                    ppt: '/static/images/ppt.png',
                    csv: '/static/images/csv.png',
                    xlsx: '/static/images/xlsx.jpg',
                    xls: '/static/images/xlsx.jpg',
                    doc: '/static/images/doc.jpg',
                    docx: '/static/images/doc.jpg',
                    txt: '/static/images/doc.jpg'
                };
                imgSrc = fileIcons[file_ext] || src;
            }
    
            $('<img>', { src: imgSrc }).appendTo($container);
    
            let $button = $('<button>', { class: 'delete-image' }).appendTo($container);
            $('<i>', { class: 'bx bx-x' }).appendTo($button);
    
            if (plugin.settings.preloaded.length) {
                $container.attr('data-preloaded', true);
                $('<input>', {
                    type: 'hidden',
                    name: plugin.settings.preloadedInputName + '[]',
                    value: id
                }).appendTo($container);
            } else {
                $container.attr('data-index', id);
            }
    
            $button.on("click", function (e) {
                prevent(e);
    
                if ($container.data('index') !== undefined) {
                    let index = parseInt($container.data('index'));
                    dataTransfer.items.remove(index);
                    updateIndexes($container, index);
                }
    
                $container.remove();
                if (!$container.closest('.image-uploader').find('.uploaded .uploaded-image').length) {
                    $container.closest('.image-uploader').removeClass('has-files');
                }
            });
    
            return $container;
        };
    
        let updateIndexes = function ($container, removedIndex) {
            let $uploadedContainer = $container.closest('.uploaded');
            $uploadedContainer.find('.uploaded-image[data-index]').each(function () {
                let currentIndex = parseInt($(this).data('index'));
                if (currentIndex > removedIndex) {
                    $(this).attr('data-index', currentIndex - 1);
                }
            });
        };
    
        let fileDragHover = function (e) {
            prevent(e);
            if (e.type === "dragover") {
                $(this).addClass('drag-over');
            } else {
                $(this).removeClass('drag-over');
            }
        };
    
        let fileSelectHandler = function (e) {
            prevent(e);
            let $container = $(this);
            $container.removeClass('drag-over');
    
            let files = e.target.files || e.originalEvent.dataTransfer.files;
            setPreview($container, files);
        };
    
        let setPreview = function ($container, files) {
            $container.addClass('has-files');
            let $uploadedContainer = $container.find('.uploaded'),
                $input = $container.find('input[type="file"]');
    
            $(files).each(function (i, file) {
                let fileExt = file.name.split('.').pop().toLowerCase();
                dataTransfer.items.add(file);
                $uploadedContainer.append(createImg(URL.createObjectURL(file), dataTransfer.items.length - 1, fileExt));
            });
    
            $input.prop('files', dataTransfer.files);
        };
    
        let random = function () {
            return Date.now() + Math.floor((Math.random() * 100) + 1);
        };
    
        this.init();
        return this;
    };

}(jQuery));