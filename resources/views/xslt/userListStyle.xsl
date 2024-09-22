<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:param name="userFilter" select="'user'"/>
    <xsl:template match='/users'>
        <html>
            <head>
                <style>
                    table {
                        border-collapse: collapse;
                        width: 90%; 
                        margin: 30px auto; 
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                    td {
                        max-width: 200px;
                        word-wrap: break-word; 
                    }
                    button {
                        padding: 5px 10px;
                        background-color: #4CAF50;
                        color: white;
                        border: none;
                        cursor: pointer;
                    }
                    button:hover {
                        background-color: #45a049;
                    }
                </style>
            </head>
            <body>
                <table border="1">
                    <thead>
                        <tr>
                            <th>
                                Id
                            </th>
                            <th>
                                Name
                            </th>
                            <th>Email</th>
                            <th>Last Login</th>
                            <th>
                               Days Since Last Login
                            </th>
                            <th>
                               Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <div style="text-align: center;">
                            <a href="?userFilter=user">Users</a> |
                            <a href="?userFilter=admin">Admins</a>
                        </div>
                        <xsl:for-each select="user[usertype=$userFilter]">
                            <xsl:sort select="difference_in_days" data-type="number" order="descending"/>
                            <xsl:variable name="bgColor">
                                <xsl:choose>
                                    <xsl:when test="difference_in_days &gt; 60">#f28b82</xsl:when>
                                    <xsl:when test="difference_in_days &gt; 30 and difference_in_days &lt; 61">#fff475</xsl:when>
                                    <xsl:otherwise>#ccff90</xsl:otherwise>
                                </xsl:choose>
                            </xsl:variable>
                            <tr style="background-color: {$bgColor}">
                                <td>
                                    <xsl:value-of select="id"/>
                                </td>
                                <td>
                                    <xsl:value-of select="name"/>
                                </td>
                                <td>
                                    <xsl:value-of select="email"/>
                                </td>
                                <td>
                                    <xsl:value-of select="last_login"/>
                                </td>
                                <td>
                                    <xsl:value-of select="difference_in_days"/>
                                </td>
                                <td>
                                    <form method="POST" action="routePlaceHolder" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        <input type="hidden" name="email" value="{email}"/>
                                        <input type="hidden" name="_method" value="DELETE"/>
                                        <input type="hidden" name="_token" value="csrfPlaceHolder"/>
                                        <button type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>