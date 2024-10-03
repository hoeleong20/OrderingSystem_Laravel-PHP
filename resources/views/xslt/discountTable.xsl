<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>
    
    <xsl:template match="/">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Discount Management</h2>
                <button class="btn btn-success btn-create">Add Discount</button>
            </div>

            <table id="discountTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Promo Code</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Usage Allowed</th>
                        <th>Usage Allowed / Customer</th>
                        
                        <th>Criteria and Condition</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th data-dt-order="disable">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <xsl:for-each select="/discounts/discount">
                        <tr>
                            <td><xsl:value-of select="name"/></td>
                            <td><xsl:value-of select="description"/></td>
                            <td><xsl:value-of select="promo_code"/></td>
                            <td><xsl:value-of select="start_date"/></td>
                            <td><xsl:value-of select="end_date"/></td>
                            <td><xsl:value-of select="total_usage"/></td>
                            <td><xsl:value-of select="usage_per_user"/></td>
                            <td>
                                <ul>
                                    <xsl:for-each select="criterias/criteria">
                                        <li><xsl:value-of select="name"/> : <xsl:value-of select="condition"/></li>   
                                    </xsl:for-each>
                                </ul>
                            </td>
                            <td>
                                <xsl:choose>
                                    <xsl:when test="discount_type = 'percentage'">
                                        <xsl:value-of select="discount_value"/>%
                                    </xsl:when>
                                    <xsl:otherwise>
                                        RM <xsl:value-of select="discount_value"/>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </td>
                            <xsl:variable name="statusColor">
                                <xsl:choose>
                                    <xsl:when test="status = 'active'">green</xsl:when>
                                    <xsl:otherwise>red</xsl:otherwise>
                                </xsl:choose>
                            </xsl:variable>
                            <td style="color: {$statusColor};"><xsl:value-of select="status"/></td>
                            <td>
                                <button class="btn btn-secondary btn-view" style="margin-right: 10px;" data-id="{id}">View</button>
                                <button class="btn btn-primary btn-edit" style="margin-right: 10px;" data-id="{id}">Edit</button>

                                <xsl:choose>
                                    <xsl:when test="status = 'active'">
                                        <button class="btn btn-danger btn-delete" data-id="{id}">Delete</button>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <button class="btn btn-success btn-activate" style="margin-right: 10px;" data-id="{id}">Activate</button>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </td>
                        </tr>
                    </xsl:for-each>
                </tbody>
            </table>

            <!-- View Discount Modal -->
            <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewModalLabel">View Discount</h5>
                            <button type="button" class="btn-close" style="background-color: transparent; border: none; padding: 0;" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: black;"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="viewForm">
                            <!-- The form will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Discount Modal -->
            <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Create Discount</h5>
                            <button type="button" class="btn-close" style="background-color: transparent; border: none; padding: 0;" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: black;"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="createForm">
                            <!-- The form will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Discount Modal -->
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Discount</h5>
                            <button type="button" class="btn-close" style="background-color: transparent; border: none; padding: 0;" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: black;"></i>
                            </button>
                        </div>
                        <div class="modal-body" id="editForm">
                            <!-- The form will be loaded here via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" style="background-color: transparent; border: none; padding: 0;" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: black;"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this discount?
                        </div>
                        <div class="modal-footer">
                            <form id="deleteConfirmationForm" method="POST">
                                <xsl:call-template name="csrf"/>
                                <input type="hidden" name="_method" value="DELETE"/>
                                <button type="submit" class="btn btn-danger" style="margin-right: 10px;" >Delete</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activate Confirmation Modal -->
            <div class="modal fade" id="activateConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmModalLabel">Confirm Activation</h5>
                            <button type="button" class="btn-close" style="background-color: transparent; border: none; padding: 0;" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" style="color: black;"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to activate this discount?
                        </div>
                        <div class="modal-footer">
                            <form id="activateConfirmationForm" method="POST">
                                <xsl:call-template name="csrf"/>
                                <input type="hidden" name="_method" value="PATCH"/>
                                <button type="submit" class="btn btn-success" style="margin-right: 10px;" >Activate</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </xsl:template>
    <xsl:template name="csrf">
        <input type="hidden" name="_token" value="{token}"/>
    </xsl:template>
</xsl:stylesheet>
