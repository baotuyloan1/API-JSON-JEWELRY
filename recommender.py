#!D:\VKU\Python\python.exe

print("Content-Type: text/html\n")



import mysql.connector
import json
#đọc json thành csv
import pandas as pd
import numpy as np
from scipy.sparse import csr_matrix
from sklearn.neighbors import NearestNeighbors
import sys

#get the arguments passed
argList = sys.argv

class Discount:
    def __init__(self, id ,discount_percent, discount_object):
        self.id = int(id)
        self.discount_percent = int(discount_percent)
        self.discount_object = discount_object
    def dump(self):
        return {'discount_id': self.id,'discount_percent': self.discount_percent,'discount_object': self.discount_object,
}
    def encodeJson(discounts):
        res = json.dumps([o.dump() for o in discounts], indent=3)
        return res

class Product:
    def __init__(self, id, name, price, image, distance , discountID ):
        self.id = int(id)
        self.name = name
        self.price = double(price)
        self.image = image
        self.distance = double(distance)
        self.discountID = int(discountID)


    def dump(self):
        return {'id': self.id,
                               'name': self.name,
                               'price': self.price,
                               'image':self.image,
                               'distance':self.distance,
                               'discountID':self.discountID
                              }
    def encodeJson(products):
        res = json.dumps([o.dump() for o in products], indent=3)
        return res
        
    

userId = 14


# import matplotlib.pyplot as plt


from numpy import double, product

conn = mysql.connector.connect(host = "localhost",port= "3306", user="truyenbo", password="Truyenbo99", database="jewel")
cursor = conn.cursor()
selectquery = "select * from tbl_product"
cursor.execute(selectquery)
records = cursor.fetchall()


products = []
product = []

for row in records:

    # print("")
    # print("product_id:",row[0])
    # print("category id",row[1])
    
    #print(product_df)
    product = [row[0],row[2],row[3],row[5],row[6]]
    products.append(product)
#res = json.dumps([o.dump() for o in products], indent=3)
#print(res)
products_df = pd.DataFrame (products, columns = ['ProductID', 'DiscountID','ProductName','ProductImage','ProductPrice'])
selectquery = "select * from tbl_rating"
# selectquery = """select * from tbl_rating where user_id = %s"""
# data = (userId,)
cursor.execute(selectquery)
# cursor.execute(selectquery , data)
records = cursor.fetchall()
ratings = []
rating = []

if (len(records) > 3):
   
    for row in records:
    # print("")
    # print("product_id:",row[2])
    # print("category id",row[1])
    
    #print(product_df)
        rating = [row[2],row[1],row[3],row[7]]
        ratings.append(rating)
  
    # res = json.dumps([o.dump() for o in products], indent=3)
    



   
    ratings_df = pd.DataFrame (ratings, columns = ['UserID', 'ProductID','Rating','Timestamp'])
    # print(products_df.head())
    # print(ratings_df.head())




    # print('The Number of Products in Dataset', len(products_df))
    products_df['List Index'] = products_df.index
    # print(products_df.head())

    # Merge products_df with ratings_df by ProductId
    merged_df = products_df.merge(ratings_df, on='ProductID')
    # print(merged_df)
    # Drop unnecessary columns
    # merged_df = merged_df.drop('Timestamp', axis=1).drop('Title', axis=1).drop('categoryId', axis=1)

    # print(len(merged_df))
    # print(merged_df)



    combine_product_rating = merged_df.dropna(axis = 0, subset = ['ProductName'])
    product_ratingCount = (combine_product_rating.
        groupby(by = ['ProductID'])['Rating'].
        count().
        reset_index().
        rename(columns = {'Rating': 'totalRatingCount'})
        [['ProductID', 'totalRatingCount']]
        )
    product_ratingTotal = (combine_product_rating.
        groupby(by = ['ProductID'])['Rating'].
        sum().
        reset_index().
        rename(columns = {'Rating': 'ratingTotal'})
        [['ProductID', 'ratingTotal']]
        )
    
    product_ratingCount = product_ratingCount.merge(product_ratingTotal, on='ProductID')
    product_ratingCount['mean'] = product_ratingCount['ratingTotal']/product_ratingCount['totalRatingCount']
    product_ratingCount =  product_ratingCount.sort_values(by=['mean','totalRatingCount'],ascending=False)
    
    # print(product_ratingCount)
    
    # product_ratingCount = combine_product_rating.groupby(by = ['ProductID','Rating']).sum()
    # product_ratingCount['Mean']  = product_ratingCount["totalRating"] / product_ratingCount["totalRatingCount"]

    # product_ratingCount.groupby(by = ['ProductID'])

    
    rating_with_totalRatingCount = combine_product_rating.merge(product_ratingCount, left_on = 'ProductID', right_on = 'ProductID', how = 'left')
    rating_with_totalRatingCount =  rating_with_totalRatingCount.sort_values(by=['mean','totalRatingCount'],ascending=False)
    # print(rating_with_totalRatingCount.head())

    pd.set_option('display.float_format', lambda x: '%.3f' % x)
    # print(product_ratingCount['totalRatingCount'].describe())

    popularity_threshold = 1
    
    rating_popular_product= rating_with_totalRatingCount.query('totalRatingCount >= @popularity_threshold')
    # print(rating_popular_product.head())


    # print(rating_popular_product.shape)

    ## First lets create a Pivot matrix

    product_features_df=rating_popular_product.pivot_table(index=['ProductID' ,'ProductName','ProductPrice','ProductImage', 'DiscountID'],columns='UserID',values='Rating').fillna(0)
    # print("product_features_df",product_features_df.head())

    # print(product_features_df)
    

    product_features_df_matrix = csr_matrix(product_features_df.values)

   


    model_knn = NearestNeighbors(metric = 'cosine', algorithm = 'brute')
    model_knn.fit(product_features_df_matrix)




    # query_index = np.random.choice(product_features_df.shape[0])
    query_index = 1
    # print(query_index)
    distances, indices = model_knn.kneighbors(product_features_df.iloc[query_index,:].values.reshape(1, -1), n_neighbors = 15)

    arrayProducts =[]
    arrayDiscounts =[]
    
    for i in range(0, len(distances.flatten())):
        if i == 0:
            # print('Recommendations for {0}:\n'.format(product_features_df.index[query_index]))
            # arrayProductsId.append(product_features_df.index[indices.flatten()[i]])
            continue
        else:
            # print('{0}: {1}, with distance of {2}:'.format(i, product_features_df.index[indices.flatten()[i]], distances.flatten()[i]))
            productId = product_features_df.index[indices.flatten()[i]][0]
            productName =  product_features_df.index[indices.flatten()[i]][1]
            productPrice =  product_features_df.index[indices.flatten()[i]][2]
            productImage = product_features_df.index[indices.flatten()[i]][3]
            discountId = product_features_df.index[indices.flatten()[i]][4]
            sql = "SELECT * FROM tbl_discount WHERE discount_id = 4"
            val = (discountId)
            cursor.execute(sql,val)
            records = cursor.fetchall()
            for row in records:
                discount_percent = row[2]
                discount_object = row[3]
            arrayDiscounts.append(Discount(id=discountId , discount_percent=discount_percent , discount_object= discount_object))
            d = Discount.encodeJson(discounts= arrayDiscounts)
            # print(d)
            arrayProducts.append(Product(id= productId, name= productName, price= productPrice, image = productImage , distance= distances.flatten()[i] , discountID=discountId))

    # argList = arrayProducts
    # print(arrayProducts)
    p = Product.encodeJson(products= arrayProducts)
    print(p)

else:
    print(0)
