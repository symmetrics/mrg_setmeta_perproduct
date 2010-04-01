# encoding: utf-8


# =============================================================================
# package info
# =============================================================================
NAME = 'symmetrics_module_setmeta_perproduct'

TAGS = ('php', 'magento', 'symmetrics', 'module', 'meta', 'product', 'javascript')

LICENSE = 'AFL 3.0'

HOMEPAGE = 'http://www.symmetrics.de'

INSTALL_PATH = ''


# =============================================================================
# responsibilities
# =============================================================================
TEAM_LEADER = {
    'Sergej Braznikov': 'sb@symmetrics.de',
    'Torsten Walluhn': 'tw@symmetrics.de'
}

MAINTAINER = {
    'Eric Reiche': 'er@symmetrics.de'
}

AUTHORS = {
    'Eric Reiche': 'er@symmetrics.de'
}

# =============================================================================
# additional infos
# =============================================================================
INFO = 'Meta Informationen mit Produkt-Info fuellen'

SUMMARY = '''
Dieses Modul soll mithilfe von Javascript die Meta Informationen eines Produktes mit 
den Informationen der Kategorie und des Produktnamens füllen.
Feature #1827
'''

NOTES = '''
'''

# =============================================================================
# relations
# =============================================================================
REQUIRES = [
    {'magento': '*', 'magento_enterprise': '*'}
]

EXCLUDES = {}

VIRTUAL = {}

DEPENDS_ON_FILES = ()

PEAR_KEY = ''

COMPATIBLE_WITH = {
    'magento': ['1.4.0.0'],
    'magento_enterprise': ['1.7.0.0', '1.7.1.0'],
}
