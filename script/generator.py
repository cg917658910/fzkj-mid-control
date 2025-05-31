# Write a full CLI-compatible generator.py that supports submodule paths
import json
import os
import sys
from datetime import datetime


def load_config(path='config.json'):
    with open(path, 'r', encoding='utf-8') as f:
        return json.load(f)


def to_pascal(name):
    return ''.join(part.capitalize() for part in name.split('_'))


def to_lower(name):
    return name.lower()


def get_namespace_and_paths(full_name):
    parts = full_name.strip('/').split('/')
    module_name = parts[-1]
    namespace_path = '\\\\' + '\\\\'.join(parts[:-1]) if len(parts) > 1 else ''
    file_subpath = os.path.join(*parts[:-1]) if len(parts) > 1 else ''
    return module_name, namespace_path, file_subpath


def process_template(template, name, config_vars, extra_vars):
    for key, rule in config_vars.items():
        if rule == "PascalCase":
            template = template.replace(key, to_pascal(name))
        elif rule == "lowercase":
            template = template.replace(key, to_lower(name))
        elif rule == "date":
            template = template.replace(
                key, datetime.now().strftime("%Y-%m-%d %H:%M"))
        elif rule == "author":
            template = template.replace(
                key, os.getenv("USERNAME") or "AutoGen")
        elif rule == "namespace_path":
            template = template.replace(key, extra_vars["namespace"])
    return template


def generate(full_name, config, only_layers=None):
    module_name, namespace_path, sub_path = get_namespace_and_paths(full_name)

    for layer, opts in config["layers"].items():
        if only_layers and layer not in only_layers:
            continue

        tpl_file = opts["template"]
        if not os.path.exists(tpl_file):
            print(f"[跳过] 模板不存在: {tpl_file}")
            continue

        with open(tpl_file, 'r', encoding='utf-8') as f:
            template = f.read()

        filename = opts["filename"].replace("{name}", to_pascal(module_name))
        target_dir = os.path.join(opts["output"], sub_path)
        os.makedirs(target_dir, exist_ok=True)
        target_file = os.path.join(target_dir, filename)

        if os.path.exists(target_file) and not config.get("overwrite", False):
            print(f"[跳过] 已存在: {target_file}")
            continue

        result = process_template(template, module_name, config["replace_vars"], {
            "namespace": namespace_path
        })

        with open(target_file, 'w', encoding='utf-8') as f:
            f.write(result)
        print(f"[生成] {target_file}")


def parse_args():
    if len(sys.argv) < 2:
        print("用法: python generator.py 模块名 [模块名2 ...] [--only=x,y]")
        sys.exit(1)

    only_layers = None
    names = []

    for arg in sys.argv[1:]:
        if arg.startswith("--only="):
            only_layers = arg.split("=")[1].split(",")
        else:
            names.append(arg)

    return names, only_layers


if __name__ == "__main__":
    names, only_layers = parse_args()
    config = load_config()
for full_name in names:
    generate(full_name, config, only_layers)
