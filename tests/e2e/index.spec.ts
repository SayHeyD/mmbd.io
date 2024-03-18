import {expect, test} from '@playwright/test';
import common from './common';

test('The index page loads', async ({ page, context }) => {
    await page.goto(`${common.appUrl}`);
    await expect(page.getByRole('heading', { name: 'mmbd.io' })).toBeVisible();
});
