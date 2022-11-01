/**
 * Equaltrue (shuvoenr@gmail.com)
 *
 * This source file is subject to the Equaltrue license
 *
 * @category  Core
 * @package   Equaltrue_Core
 * @copyright Copyright (c) Equaltrue (https://equaltrue.com)
 * @author    Suvankar Paul
 */
define(
    [
        'underscore',
        'Magento_Ui/js/grid/columns/column'
    ],
    function (_, Column) {
        'use strict';

        return Column.extend(
            {
                defaults: {
                    bodyTmpl: 'Equaltrue_Core/grid/cells/status',
                    fieldClass: {
                        'data-grid-thumbnail-cell': true
                    }
                },

                getIsActive: function (record) {
                    return (record[this.index] === 1 || record[this.index] === '1');
                },

                /**
                 * Retrieves label associated with a provided value.
                 *
                 * @returns {String}
                 */
                getLabel: function () {

                    let options = this.options || [],
                        values = this._super(),
                        label = [];

                    if (!Array.isArray(values)) {
                        values = [values];
                    }

                    values = values.map(
                        function (value) {
                            return value + '';
                        }
                    );

                    options.forEach(
                        function (item) {
                            if (_.contains(values, item.value + '')) {
                                label.push(item.label);
                            }
                        }
                    );

                    return label.join(', ');
                }
            }
        );
    }
);
