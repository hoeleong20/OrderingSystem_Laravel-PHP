package com.checkdiscount;

import java.util.Map;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RestController;
import java.sql.*;
import java.io.IOException;
import java.io.InputStream;
import java.time.LocalDate;
import java.time.format.DateTimeParseException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Properties;
import org.springframework.web.bind.annotation.RequestParam;

@RestController
public class CheckDiscountController {
    private String url;
    private String username;
    private String password = "";
    private String errorMessage = "error: ";
    private Connection connection;
    
    @GetMapping("/checkDiscount")
    public String checkDiscount(@RequestParam Map<String, String> params) throws ClassNotFoundException {
        readDatabaseCredential();
        errorMessage = "error: ";
        
        Class.forName("com.mysql.cj.jdbc.Driver");
        try (Connection connection = DriverManager.getConnection(url, username, password)) {               
            this.connection = connection;
            
            double amount = Double.parseDouble(params.getOrDefault("total_amount", "0"));
            int userId = Integer.parseInt(params.getOrDefault("user_id", "-1"));
            
            if (userId == -1 || amount == 0) 
                return "";
            
            String availablePromoCode = "";
            if (params.containsKey("promo_code")) {
                String promoCode = params.get("promo_code").toString();
                boolean eligibleDiscount = checkPromoCodeEligible(promoCode, amount, userId);
                
                if (eligibleDiscount) {
                    availablePromoCode = promoCode;                    
                }
            } else {
                String promoCode = checkAutoAppliedDiscount(amount, userId);
                
                if (promoCode != null) {
                    availablePromoCode = promoCode;
                }
            }
            
            if (!availablePromoCode.equals(""))
                return availablePromoCode;
            
            return errorMessage;
            
        } catch (SQLException ex) {
            System.out.println("sql" + ex.toString());
            return "error: Bad connection to database.";
        }
    }
    
    private boolean checkPromoCodeEligible(String promoCode, double amount, int userId) throws SQLException {
        String[][] criterias = getDiscountCriteriaAndCondition(promoCode, userId);        
        LocalDate userCreationDate = getUserCreationTime(userId);
        
        if (criterias == null)
            return false;
        
        if (criterias.length == 0) // No usage criteria
            return true;
        
        for (String[] criteria : criterias) {
            String condition = criteria[1];
            switch (criteria[0]) {
                case "new_user":
                    LocalDate today = LocalDate.now();
                    LocalDate newUserExpiryDate = addDurationToDate((LocalDate) userCreationDate, condition);

                    if (today.isAfter(newUserExpiryDate)) {
                        errorMessage += "The promotion is for new user only.";
                        return false;
                    }
                    
                    break;
                case "min_purchase":
                    double minAmount = Double.parseDouble(condition);
                    
                    if (amount < minAmount) {
                        errorMessage += "The amount does not reach the minimum amount (RM" + String.format("%.2f", minAmount) + ")";
                        return false;
                    }
                    
                    break;
            }
        }
        
        return true;
    }
    
    private String checkAutoAppliedDiscount(double amount, int userId) throws SQLException {
        List<Map<String, Object>> list = getDiscountCriteriaAndCondition(userId);
        LocalDate userCreationDate = getUserCreationTime(userId);
        
        if (list == null)
            return "";
        
        double bestAmount = amount;
        String bestPromoCode = "";
        for (Map<String, Object> map : list) {
            String discountType = (String) map.get("discountType");
            double discountValue = (double) map.get("discountValue");
            
            boolean breakFlag = false;
            if (map.containsKey("criterias")) {
                String[][] criterias = (String[][]) map.get("criterias");
                for (String[] criteria : criterias) {
                    String condition = criteria[1];
                    switch (criteria[0]) {
                        case "new_user":
                            LocalDate today = LocalDate.now();
                            LocalDate newUserExpiryDate = addDurationToDate((LocalDate) userCreationDate, condition);

                            if (today.isAfter(newUserExpiryDate)) {
                                errorMessage += "The promotion is for new user only.";
                                breakFlag = true;
                            }

                            break;
                        case "min_purchase":
                            double minAmount = Double.parseDouble(condition);

                            if (amount < minAmount) {
                                errorMessage += "The amount does not reach the minimum amount (RM" + String.format("%.2f", minAmount) + ")";
                                breakFlag = true;
                            }

                            break;
                    }

                    if (breakFlag)
                        break;
                }
            }
            
            if (!breakFlag) {
                double newAmount = calculateDiscountAmount(amount, discountType, discountValue);
                if (newAmount < bestAmount) {
                    bestAmount = newAmount;
                    bestPromoCode = (String) map.get("promoCode");
                }
            }
        }
        
        return bestPromoCode;
    }
    
    private double calculateDiscountAmount(double amount, String discountType, double discountValue) {
        if (discountType.equals("percentage")) {
            return amount - (amount * discountValue / 100);
        } else {
            return amount - discountValue;
        }
    }
    
    private List<Map<String, Object>> getDiscountCriteriaAndCondition(int userId) throws SQLException {
        String sql = "SELECT d.promo_code, d.description, d.discount_type, d.discount_value, d.criteria, d.condition " +
        "FROM discounts d " +
        "LEFT JOIN orders o ON d.id = o.discount_id " +
        "WHERE d.status = 'active' " +  // Discount status is active
        "AND CURDATE() BETWEEN d.start_date AND d.end_date " +  // Current date is between start and end date
        "AND (d.total_usage = -1 OR (SELECT COUNT(*) FROM orders WHERE discount_id = d.id) < d.total_usage) " +  // Check total usage
        "AND (d.usage_per_user = -1 OR (SELECT COUNT(*) FROM orders WHERE discount_id = d.id AND customerID = ?) < d.usage_per_user)";
        
        PreparedStatement preparedStatement = connection.prepareStatement(sql);

        preparedStatement.setInt(1, userId);  // Set the user ID
        
        ResultSet resultSet = preparedStatement.executeQuery();
        
        List<Map<String, Object>> list = new ArrayList<>();
        while (resultSet.next()) {
            Map<String, Object> map = new HashMap<>();
            
            String[] criteria = resultSet.getString("criteria").split(", ");
            String[] condition = resultSet.getString("condition").split(", ");
            String promoCode = resultSet.getString("promo_code");
            String discountType = resultSet.getString("discount_type");
            double discountValue = Double.parseDouble(resultSet.getString("discount_value"));

            if (criteria.length != 0) {
                String[][] criterias = new String[criteria.length][2];
                for (int i = 0; i < criteria.length; i++) {
                    criterias[i][0] = criteria[i];
                    criterias[i][1] = condition[i];
                }

                map.put("criterias", criterias);
            }
            map.put("promoCode", promoCode);
            map.put("discountType", discountType);
            map.put("discountValue", discountValue);
            
            list.add(map);
        }
        
        if (list.isEmpty()) {
            return null;
        }
        
        return list;
    }
    
    private String[][] getDiscountCriteriaAndCondition(String promoCode, int userId) throws SQLException {
        String discountSql = "SELECT d.promo_code, d.description, d.discount_type, d.discount_value, d.criteria, d.condition " +
                     "FROM discounts d " +
                     "LEFT JOIN orders o ON d.id = o.discount_id " +
                     "WHERE d.promo_code = ? " +
                     "AND d.status = 'active' " +  // Discount status is active
                     "AND CURDATE() BETWEEN d.start_date AND d.end_date " +  // Current date is between start and end date
                     "AND (d.total_usage = -1 OR (SELECT COUNT(*) FROM orders WHERE discount_id = d.id) < d.total_usage) " +  // Check total usage
                     "AND (d.usage_per_user = -1 OR (SELECT COUNT(*) FROM orders WHERE discount_id = d.id AND o.customerID = ?) < d.usage_per_user)";  // Check per-user usage

        PreparedStatement discountStatement = connection.prepareStatement(discountSql);
        discountStatement.setString(1, promoCode);
        discountStatement.setInt(2, userId);
        ResultSet discountResultSet = discountStatement.executeQuery();
        
        String[][] criterias;
        
        if (!discountResultSet.next()) {
            errorMessage += "There is no active promotion for the promo code, or it is used up.";
            return null;
        }
        
        String[] criteria = discountResultSet.getString("criteria").split(", ");
        String[] condition = discountResultSet.getString("condition").split(", ");

        
        criterias = new String[criteria.length][2];
        for (int i = 0; i < criteria.length; i++) {
            criterias[i][0] = criteria[i];
            criterias[i][1] = condition[i];
        }
        
        return criterias;
    }
    
    private LocalDate getUserCreationTime(int userId) throws SQLException {
        String userSql = "SELECT created_at " +
                 "FROM users " +
                 "WHERE id = ?";

        PreparedStatement userStatement = connection.prepareStatement(userSql);
        userStatement.setInt(1, userId);  // Set the user ID
        ResultSet userResultSet = userStatement.executeQuery();

        // Process user results
        if (userResultSet.next()) {
            LocalDate userCreationTime = userResultSet.getTimestamp("created_at").toLocalDateTime().toLocalDate();
            return userCreationTime;
        }
        
        return null;
    }
    
    private void readDatabaseCredential() {
        Properties properties = new Properties();
        try (InputStream input = getClass().getClassLoader().getResourceAsStream("database.properties")) {
            if (input == null) {
                System.out.println("Sorry, unable to find database.properties");
                return;
            }
            properties.load(input);
            
            this.url = properties.getProperty("db.url");
            this.username = properties.getProperty("db.username");
            this.password = properties.getProperty("db.password"); 
        } catch (IOException ex) {
            ex.printStackTrace();
        }
    }
    
    private LocalDate parseDate(String dateStr) {
        try {
            // Parse the date using the default ISO format (yyyy-MM-dd)
            return LocalDate.parse(dateStr);
        } catch (DateTimeParseException e) {
            System.err.println("Invalid date format: " + dateStr);
            return null;
        }
    }
    
    private LocalDate addDurationToDate(LocalDate date, String duration) {
        String[] parts = duration.split(" ");
        int amount = Integer.parseInt(parts[0]);
        String unit = parts[1];

        switch (unit) {
            case "days":
                return date.plusDays(amount);
            case "months":
                return date.plusMonths(amount);
            case "years":
                return date.plusYears(amount);
            default:
                throw new IllegalArgumentException("Unknown time unit: " + unit);
        }
    }
}
