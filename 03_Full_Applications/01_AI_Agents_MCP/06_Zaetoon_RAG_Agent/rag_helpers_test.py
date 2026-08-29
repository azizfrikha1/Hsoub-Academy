import os
from dotenv import load_dotenv
import rag_helpers as rag

load_dotenv()

articles_json_file = os.getenv("articles_json_file", "data/articles.json").strip()
chroma_store_path = os.getenv("chroma_store_path", "data/chroma_store").strip()
chroma_db_name = os.getenv("chroma_db_name", "articles_db").strip()
embedding_model_name = os.getenv(
    "embedding_model_name", "sentence-transformers/paraphrase-multilingual-MiniLM-L12-v2"
).strip()
gpt_model_name = os.getenv("gpt_model_name", "gpt-4o").strip()

if __name__ == "__main__":
    rag.build_chromadb(articles_json_file, chroma_store_path, chroma_db_name, embedding_model_name)

    msg = "ما أسعار الآيفون لديكم؟"
    conversation = "ما أسعار الآيفون لديكم؟"
    reply = rag.answer_client_rag(
        conversation, msg, chroma_store_path, chroma_db_name, embedding_model_name, gpt_model_name
    )
    print(reply)