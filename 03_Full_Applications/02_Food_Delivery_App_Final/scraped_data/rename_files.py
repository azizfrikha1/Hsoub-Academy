import os

DIR = r'D:\Hsoub\AI_Course\food_app\scraped_data\example'

id = 0

def rename_files(path: str):
	global id
	for file_name in os.listdir(path):
		file_path = os.path.join(path, file_name)
		if os.path.isdir(file_path):
			rename_files(file_path)
			continue
		new_file_path = os.path.join(path, f'img_{id}.jpg')
		os.rename(file_path, new_file_path)
		id += 1

rename_files(DIR)

