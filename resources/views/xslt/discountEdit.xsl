<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>
    <xsl:param name="formUrl"/>

    <xsl:template match="/">
        <form action="{$formUrl}" method="POST" onsubmit="mergeFormInput(this)">
            <xsl:call-template name="csrf"/>
            <input type="hidden" name="id" value="{discount/id}"/>
            <div class="form-group">
                <!-- Discount Name -->
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{discount/name}" required="true" /><br/>

                <!-- Discount Description -->
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" 
                       value="{discount/description}" required="true" /><br/>

                <!-- Promo Code -->
                <label for="promo_code">Promo Code</label>
                <input type="text" name="promo_code" id="promo_code" class="form-control" 
                       value="{discount/promo_code}" required="true" /><br/>

                <!-- Start Date -->
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control" 
                       value="{discount/start_date}" required="true" /><br/>

                <!-- End Date -->
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control" 
                       value="{discount/end_date}" required="true" /><br/>

                <!-- Total Usage -->
                <label for="total_usage">Total Usage Allowed (-1 for unlimited)</label>
                <input type="number" name="total_usage" id="total_usage" class="form-control" 
                       value="{discount/total_usage}" required="true" min="-1" /><br/>

                <!-- Usage Per User -->
                <label for="usage_per_user">Usage Per User</label>
                <input type="number" name="usage_per_user" id="usage_per_user" class="form-control" 
                       value="{discount/usage_per_user}" required="true" min="-1" /><br/>

                <!-- Criteria List -->
                <div class="form-group">
                    <label>Criteria</label><br/>
                    <div id="criteriaContainer">
                        <xsl:for-each select="discount/criterias/criteria">
                        <div class="criteria">
                            <!-- Criteria name select -->
                            <select name="criteriaNames[]" class="form-control criteria-select" onchange="updateCriteriaInputs(this)">
                                <option value="new_user">
                                <xsl:if test="name = 'new_user'">
                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                </xsl:if>
                                New User</option>
                                <option value="min_purchase">
                                <xsl:if test="name = 'min_purchase'">
                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                </xsl:if>
                                Min Purchase</option>
                            </select>

                            <div class="criteria-inputs row" style="margin-top:5px;">
                                <xsl:choose>
                                    <!-- New User Option -->
                                    <xsl:when test="name = 'new_user'">                                    
                                        <xsl:variable name="conditionNumber" select="substring-before(condition, ' ')" />
                                        <xsl:variable name="conditionUnit" select="substring-after(condition, ' ')" />
                                        <div class="col-md-7">
                                            <input type="number" name="newUserDay[]" class="form-control" value="{$conditionNumber}" required="true" min="1"/>
                                        </div>

                                        <div class="col-md-3">
                                            <select name="newUserTimeUnit[]" class="form-control">
                                                <option value="days">
                                                <xsl:if test="conditionUnit = 'days'">
                                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                                </xsl:if>
                                                Days</option>
                                                <option value="months">
                                                <xsl:if test="conditionUnit = 'months'">
                                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                                </xsl:if>
                                                Months</option>
                                                <option value="years">                
                                                <xsl:if test="conditionUnit = 'years'">
                                                    <xsl:attribute name="selected">selected</xsl:attribute>
                                                </xsl:if>
                                                Years</option>
                                            </select>
                                        </div>
                                        
                                        <input type="hidden" name="conditions[]" />
                                    </xsl:when>

                                    <!-- Minimum Purchase Option -->
                                    <xsl:when test="name = 'min_purchase'">
                                        <div class="col-md-10">                
                                            <div class="input-group">
                                                <span class="input-group-text">> RM</span>
                                                <input type="text" name="conditions[]" class="form-control" value="{condition}" required="true" min="0" />
                                            </div>
                                        </div>
                                    </xsl:when>
                                </xsl:choose>
                                
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-block" onclick="removeCriteria(this)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div><br/>
                        </div>
                        </xsl:for-each>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" id="addCriteriaButton">Add Criteria</button>
                </div><br/>

                <!-- Discount Type -->
                <label for="discount_type">Discount Type</label>
                <select name="discount_type" id="discount_type" class="form-control" onchange="updateDiscountValueInput()">
                    <option value="percentage">
                    <xsl:if test="discount/discount_type = 'percentage'">
                        <xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Percentage</option>
                    <option value="fixed">
                    <xsl:if test="discount/discount_type = 'fixed'">
                        <xsl:attribute name="selected">selected</xsl:attribute>
                    </xsl:if>
                    Fixed</option>
                </select>

                <!-- Discount Value -->
                <div class="input-group" style="margin-top:5px;">
                    <span class="input-group-text" id="discount_prefix">
                        <xsl:if test="discount/discount_type = 'percentage'">
                            <xsl:attribute name="style">display:none;</xsl:attribute>
                        </xsl:if>
                        RM
                    </span>
                    <input type="text" name="discount_value" id="discount_value" class="form-control" value="{discount/discount_value}" required="true" min="0"/>
                    <span class="input-group-text" id="discount_suffix">
                        <xsl:if test="discount/discount_type = 'fixed'">
                            <xsl:attribute name="style">display:none;</xsl:attribute>
                        </xsl:if>
                        %
                    </span>
                </div>
            </div>

            <!-- Save Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary btn-close" data-bs-dismiss="modal" style="margin-left: 10px;">Close</button>
            </div>
        </form>
    </xsl:template>

    <!-- CSRF Token Template -->
    <xsl:template name="csrf">
        <input type="hidden" name="_token" value="{token}"/>
    </xsl:template>
</xsl:stylesheet>
