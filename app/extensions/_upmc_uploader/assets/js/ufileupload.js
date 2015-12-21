/**
 * Created by Алексей on 29.03.14.
 */

var ufileupload;

(function () {
    ufileupload = (function (container, options) {
        this.container = container.data('ufileupload', this);
        this.options = options;
    });

    /**
     * Get ufileupload object from jquery dom element
     * @type {Function}
     */
    ufileupload.get = (function () {
        return (typeof arguments[0] === "string" ? $(arguments[0]) : arguments[0]).data('ufileupload');
    });
})();