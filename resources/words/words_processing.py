import nltk
from nltk import word_tokenize
from nltk.book import *
from nltk.corpus import stopwords

raw = open("C:/Users/Home/Downloads/merge_from_ofoct.txt", "r", encoding="utf-8").read()
tokens = word_tokenize(raw)
text = nltk.Text(tokens)

stopWords = set(stopwords.words('english'))
