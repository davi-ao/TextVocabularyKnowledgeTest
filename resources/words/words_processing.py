import csv
import nltk
from nltk import word_tokenize
from nltk.book import *
from nltk.corpus import stopwords

raw = open("C:/xampp/htdocs/TextVocabularyKnowledgeTest/resources/words/sub2_lyrics.txt", "r", encoding="utf-8").read()
tokens = word_tokenize(raw)
text = nltk.Text(tokens)
stopWords = set(stopwords.words('english'))
wordsList = [w for w in tokens if w.lower() not in stopWords and w.isalpha()]
wordsList = ", ".join(wordsList)

with open("words2.txt", 'w+', encoding="utf-8", newline='') as myfile:
     myfile.write(wordsList)
